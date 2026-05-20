<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Details #{{ $order->id }} - Dokan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; }
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none; border: none; padding: 0; margin: 0; }
        }
        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
    
    <!-- Header Actions (No Print) -->
    <div class="no-print flex justify-between items-center mb-6 flex-wrap gap-4">
        <a href="/dokan/orders" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Orders
        </a>
        <div class="flex gap-3">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Receipt
            </button>
            {{-- <button onclick="sendEmailReceipt()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email Receipt
            </button> --}}
        </div>
    </div>

    <!-- Main Receipt Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden print-container">
        
        <!-- Receipt Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6 text-white">
            <div class="flex justify-between items-start flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold">ORDER RECEIPT</h1>
                    <p class="text-indigo-100 mt-1">Official Invoice</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">{{$order->dokan->name}}</div>
                    <div class="text-sm text-indigo-100">Vendor Dashboard</div>
                </div>
            </div>
        </div>

        <!-- Order Info Section -->
        <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Order ID</p>
                    <p class="text-lg font-bold text-gray-800">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Order Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Order Status</p>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800'
                        ];
                    @endphp
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Payment Status</p>
                    @php
                        $paymentColors = [
                            'paid' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'refunded' => 'bg-gray-100 text-gray-800'
                        ];
                    @endphp
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer & Address Info -->
        <div class="grid md:grid-cols-3 gap-6 px-8 py-6">
            
            <!-- Customer Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer Details
                </h3>
                <div class="space-y-2">
                    <p class="text-gray-800 font-medium">{{ $order->user->name ?? 'N/A' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->user->email ?? 'N/A' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->user->phone ?? 'Phone not provided' }}</p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Shipping Address
                </h3>
                <div class="text-gray-600 text-sm space-y-1">
                    @php
                        $shipping = json_decode($order->shipping_address, true);
                    @endphp
                    @if($shipping)
                        <p>{{ $shipping['street'] ?? 'N/A' }}</p>
                        <p>{{ $shipping['city'] ?? 'N/A' }}, {{ $shipping['state'] ?? 'N/A' }}</p>
                        <p>{{ $shipping['zip'] ?? 'N/A' }}, {{ $shipping['country'] ?? 'N/A' }}</p>
                    @else
                        <p>No shipping address provided</p>
                    @endif
                </div>
            </div>

            <!-- Payment Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Payment Information
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Method:</span>
                        <span class="font-medium text-gray-800">{{ $order->payment_method ?? 'Cash on Delivery' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-mono text-gray-800 text-xs">{{ $order->user->id ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paid On:</span>
                        {{-- <span class="text-gray-800">{{ $order->paid_at ? date('F j, Y', strtotime($order->paid_at)) : 'Not paid yet' }}</span> --}}
                        <span class="text-gray-800">Khalti</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="px-8 py-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Order Items
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-y border-gray-200">
                        <tr class="text-left text-sm font-semibold text-gray-700">
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3 text-center">Price</th>
                            <th class="px-4 py-3 text-center">Quantity</th>
                            <th class="px-4 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($order->items as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->product->name ?? 'Product Unavailable' }}</p>
                                   
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">Rs. {{ number_format($item->product->price, 2) }}</td>
                            <td class="px-4 py-3 text-center text-gray-600">{{ $item->qty }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-800">Rs. {{ number_format($item->product->price * $item->qty, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">No items found in this order</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                        
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-600">Subtotal:</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-800">Rs. {{ number_format($order->subtotal ?? $order->items->sum(function($item) { return $item->product->price * $item->qty; }), 2) }}</td>
                        </tr>

                        @if($order->shipping_cost)
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right font-medium text-gray-600">Shipping:</td>
                            <td class="px-4 py-2 text-right text-gray-800">Rs. {{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        @endif
                        @if($order->discount)
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right font-medium text-gray-600">Discount:</td>
                            <td class="px-4 py-2 text-right text-green-600">- Rs. {{ number_format($order->$product->discount, 2) }}</td>
                        </tr>
                        @endif
                        @if($order->tax)
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right font-medium text-gray-600">Tax:</td>
                            <td class="px-4 py-2 text-right text-gray-800">Rs. {{ number_format($order->tax, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="border-t border-gray-200">
                            <td colspan="3" class="px-4 py-3 text-right text-lg font-bold text-gray-800">Total (After discount)</td>
                            <td class="px-4 py-3 text-right text-xl font-bold text-indigo-600">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->customer_notes || $order->vendor_notes)
        <div class="px-8 py-4 border-t border-gray-200 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">Order Notes</h3>
            <p class="text-gray-600 text-sm">{{ $order->customer_notes ?? $order->vendor_notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-gray-200 bg-gray-50 text-center">
            <p class="text-xs text-gray-500">Thank you for your business! For any queries, please contact {{$order->dokan->email}}</p>
            <p class="text-xs text-gray-400 mt-2">This is a computer generated receipt - No signature required</p>
        </div>
    </div>
</div>

<script>
    function sendEmailReceipt() {
        // You can implement AJAX call to send email
        fetch('#', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Receipt sent to customer email!');
            } else {
                alert('Failed to send email. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Receipt sent to customer email!'); // Fallback for demo
        });
    }
</script>

</body>
</html>