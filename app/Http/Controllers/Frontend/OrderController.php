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
            
            if($existingOrder) {
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

            DB::commit();

            // Build URL - Your base_url already contains /api/v2
            $baseUrl = rtrim(config('services.khalti.base_url'), '/');
            $url = $baseUrl . '/epayment/initiate/';
            
            // Log for debugging
            Log::info('Khalti Request:', [
                'url' => $url,
                'secret_key_exists' => !empty(config('services.khalti.secret')),
                'amount' => (int)($order->total_amount * 100)
            ]);

            // Make sure you're using 'secret' not 'secret_key' as per your config
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret')
            ])->post($url, [
                'return_url' => route('khalti.callback'),
                'website_url' => env('APP_URL'),
                'amount' => (int)($order->total_amount * 100),
                'purchase_order_id' => $order->id,
                'purchase_order_name' => "Order #" . $order->id,
            ]);

            // Check response
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['payment_url'])) {
                    Log::info('Khalti Success:', ['payment_url' => $responseData['payment_url']]);
                    return redirect($responseData['payment_url']);
                } else {
                    Log::error('Khalti Response missing payment_url:', $responseData);
                    toast('Invalid response from payment gateway', 'error');
                    return redirect()->back();
                }
            } else {
                // Log full error response
                Log::error('Khalti API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);
                
                // Delete the pending order
                DB::beginTransaction();
                $order->items()->delete();
                $order->delete();
                DB::commit();
                
                // Parse error message
                $errorBody = $response->json();
                $errorMsg = $errorBody['detail'] ?? $errorBody['error'] ?? $errorBody['message'] ?? 'Payment initialization failed! Please try again.';
                
                toast($errorMsg, 'error');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            toast('Order placement failed: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function callback(Request $req){
        try {
            Log::info('Khalti Callback Received:', $req->all());
            
            $order = Order::find($req["purchase_order_id"]);
            if($order) {
                // Update payment status
                $order->payment_status = $req['status'];
                $order->save();
                
                // Only delete cart if payment is successful
                if($req['status'] == 'Completed' || $req['status'] == 'complete') {
                    Cart::where('user_id', $order->user_id)
                        ->where('dokan_id', $order->dokan_id)
                        ->delete();
                    
                    toast('Order completed successfully!', 'success');
                } else {
                    toast('Payment ' . $req['status'] . '. Please try again.', 'error');
                }
            } else {
                toast('Order not found!', 'error');
                Log::error('Order not found in callback:', ['order_id' => $req["purchase_order_id"]]);
            }
        } catch (\Exception $e) {
            Log::error('Callback Error:', ['message' => $e->getMessage()]);
            toast('Payment callback error occurred.', 'error');
        }
        
        return redirect()->route('order.history');
    }

    public function orderHistory(){
        $orders = Order::orderBy('id', 'desc')
            ->where('user_id', Auth::id())
            ->where('payment_status', 'Completed')
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.order_history', compact('orders'));
    }

    public function dokan_order($record){
        $order = Order::find($record);
        return view('frontend.dokan_order', compact('order'));
    }

    // Add this method for sending email receipts
    // public function sendInvoiceEmail($id)
    // {
    //     $order = Order::findOrFail($id);
        
    //     // Add your email sending logic here
    //     // Mail::to($order->user->email)->send(new OrderReceiptMail($order));
        
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Receipt sent successfully'
    //     ]);
    // }
    
}