<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkoutDokan(Request $request, $id){
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Check if there's already a pending order for this user and dokan
            $existingOrder = Order::where('user_id', Auth::id())
                ->where('dokan_id', $id)
                ->where('payment_status', 'pending')
                ->latest()
                ->first();
            
            // If pending order exists, use it instead of creating new one
            if($existingOrder) {
                // Delete existing order items if any
                $existingOrder->items()->delete();
                $order = $existingOrder;
            } else {
                $order = new Order();
            }
            
            $order->dokan_id = $id;
            $order->user_id = Auth::guard('web')->user()->id;
            $order->total_amount = str_replace(',', '', $request->total_amt);
            $order->payment_status = 'pending';
            $order->save();

            $carts = Cart::with(['product', 'dokan'])
                ->where('user_id', Auth::id())
                ->where('dokan_id', $id)
                ->get();

            foreach($carts as $cart){
                $data = new OrderItem();
                $data->order_id = $order->id;
                $data->product_id = $cart->product_id; 
                $data->qty = $cart->qty;
                $data->amount = $cart->amount;
                $data->save();
            }

            // Don't delete cart yet - only delete after successful payment
            // Cart::where('user_id', Auth::id())
            //     ->where('dokan_id', $id)
            //     ->delete();

            DB::commit();

            // Initialize Khalti payment
            $url = rtrim(config('services.khalti.base_url'). '/') . '/epayment/initiate/';

            $response = Http::withHeaders([
                "Authorization" => "Key " . env('KHALTI_SECRET')
            ])->post($url, [
                'return_url'          => route('khalti.callback'),
                'website_url'         => env('APP_URL'),
                'amount'              => (int)($order->total_amount * 100),
                'purchase_order_id'   => $order->id,
                'purchase_order_name' => "Order #" . $order->id,
            ]);

            // Check if the request was successful
            if ($response->successful() && isset($response['payment_url'])) {
                return redirect($response['payment_url']);
            } else {
                // Log the error
                Log::error('Khalti Payment Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'order_id' => $order->id
                ]);
                
                // Delete the pending order since payment failed
                DB::beginTransaction();
                $order->items()->delete();
                $order->delete();
                DB::commit();
                
                toast('Payment initialization failed! Please try again.', 'error');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            toast('Order placement failed: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function callback(Request $req){
        try {
            $order = Order::find($req["purchase_order_id"]);
            if($order) {
                // Update payment status
                $order->payment_status = $req['status'];
                $order->save();
                
                // Only delete cart if payment is successful
                if($req['status'] == 'Completed' || $req['status'] == 'complete') {
                    // Delete cart items for this dokan
                    Cart::where('user_id', $order->user_id)
                        ->where('dokan_id', $order->dokan_id)
                        ->delete();
                    
                    toast('Order completed successfully!', 'success');
                } else {
                    // If payment failed, optionally delete the order or mark it as failed
                    // Uncomment the line below if you want to auto-delete failed orders
                    // $order->delete();
                    toast('Payment ' . $req['status'] . '. Please try again.', 'error');
                }
            } else {
                toast('Order not found!', 'error');
            }
        } catch (\Exception $e) {
            Log::error('Callback Error:', ['message' => $e->getMessage()]);
            toast('Payment callback error occurred.', 'error');
        }
        
        return redirect()->route('order.history');
    }

    public function orderHistory(){
        // Only show completed orders or all orders based on your preference
        $orders = Order::orderBy('id', 'desc')->where('user_id', Auth::id())
            ->where('payment_status', 'Completed') // Only show completed orders
            // Or use below line to show all orders
            // ->orderBy('created_at', 'desc')
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.order_history', compact('orders'));
    }
}