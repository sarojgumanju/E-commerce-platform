<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Dokan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart page with products grouped by dokans
     */
    public function index()
    {
        // Get all cart items for the logged-in user with relationships
        $cartItems = Cart::with(['product', 'dokan']) //“Fetch cart items along with their related product and dokan information.”
            ->where('user_id', Auth::id())
            ->get();
        
        // Group cart items by dokan    
        $groupedCarts = $cartItems->groupBy(function($item) { //It stores the cart items grouped under each dokan_id.
            return $item->dokan_id;
        });
        
        // Get dokan details for each group
        $cartGroups = [];
        foreach ($groupedCarts as $dokanId => $items) {
            $dokan = Dokan::find($dokanId);
            if ($dokan) {
                $cartGroups[] = [
                    'dokan' => $dokan,
                    'items' => $items,
                    'subtotal' => $items->sum(function($item) {
                        return $item->amount * $item->qty;
                    }),
                    'item_count' => $items->sum('qty')
                ];
            }
        }
        
        // Calculate cart total
        $cartTotal = $cartItems->sum(function($item) {
            return $item->amount * $item->qty;
        });
        
        return view('frontend.carts', compact('cartGroups', 'cartTotal'));
    }
    
    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $amount = $product->price - (($product->price * $product->discount) / 100);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->increment('qty', $request->qty);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'dokan_id' => $product->dokan_id,
                'qty' => $request->qty,
                'amount' => $amount
            ]);
        }

        return redirect()
            ->route('index')
            ->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request, $cartId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);
        
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->firstOrFail();
        
        $cartItem->update([
            'qty' => $request->qty
        ]);
        
        return redirect()->route('index')->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart($productId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $productId)
            ->firstOrFail();
        
        $cartItem->delete();
        
        return redirect()->route('index')->with('success', 'Item removed from cart!');
    }

   public function clearAllCart()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('index')
            ->with('success', 'Cart cleared successfully!');
    }

    public function clearDokanCart($dokanId)
        {
            Cart::where('user_id', Auth::id())
                ->where('dokan_id', $dokanId)
                ->delete();

            return redirect()->route('index')->with('success', 'Dokan cart cleared successfully!');
        }
    
   
}