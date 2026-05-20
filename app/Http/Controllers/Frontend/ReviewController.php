<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Product $product)
    {
        $orderId = request('order');

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order || $order->status !== 'delivered') {
            return redirect()->route('order.history')
                ->with('error', 'Invalid or undelivered order.');
        }

        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('order.history')
                ->with('error', 'You already reviewed this product.');
        }

        return view('frontend.review_form', [
            'product' => $product,
            'orderId' => $orderId,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Invalid order.');
        }

        if ($order->status !== 'delivered') {
            return back()->with('error', 'You can only review delivered orders.');
        }

        $orderHasProduct = $order->items()
            ->where('product_id', $product->id)
            ->exists();

        if (!$orderHasProduct) {
            return back()->with('error', 'Product not found in this order.');
        }

        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You already reviewed this product.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('order.history')
            ->with('success', 'Review submitted successfully!');
    }
}