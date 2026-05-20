<x-frontend-layout>

    <!-- Order History Page Content -->
    <div class="py-8 lg:py-12">
        <div class="container mx-auto px-4" style="width: 86%; max-width: 1400px;">

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-[#0b1e33] mb-2">
                    Order History
                </h1>

                <div class="decorative-line"></div>

                <p class="text-[#475569] mt-2">
                    Track and manage your orders
                </p>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- EMPTY STATE --}}
            @if(!$orders || count($orders) == 0)

                <div class="bg-white rounded-2xl shadow-card border border-gray-100 text-center py-16 px-4">

                    <div class="mb-6">
                        <i class="fas fa-shopping-bag text-6xl text-gray-300"></i>
                    </div>

                    <h3 class="text-2xl font-semibold text-[#0f172a] mb-3">
                        No orders yet!
                    </h3>

                    <p class="text-[#475569] mb-8">
                        You haven't placed any orders yet.
                    </p>

                    <a href="{{ route('products') }}" class="btn-primary inline-flex">
                        <i class="fas fa-store mr-2"></i>
                        Start Shopping
                    </a>

                </div>

            @else

                {{-- ORDERS --}}
                <div class="space-y-6">

                    @foreach($orders as $order)

                        <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">

                            <!-- ORDER HEADER -->
                            <div class="bg-gradient-to-r from-[#f8fafc] to-white p-5 border-b border-gray-100">

                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                                    <div>

                                        <div class="flex flex-col gap-3 mb-2">

                                            <h4 class="text-xl font-bold text-[#0b1e33]">
                                                Order #{{ $order->id }}
                                            </h4>

                                            {{-- PAYMENT STATUS --}}
                                            <div class="flex items-center gap-2">

                                                <h1 class="text-lg text-[#0b1e33]">
                                                    Payment Status:
                                                </h1>

                                                <span class="px-3 py-1 rounded-full text-xs font-medium

                                                    @if($order->payment_status == 'Completed')
                                                        bg-green-100 text-green-700
                                                    @elseif($order->payment_status == 'Pending')
                                                        bg-yellow-100 text-yellow-700
                                                    @elseif($order->payment_status == 'Failed')
                                                        bg-red-100 text-red-700
                                                    @else
                                                        bg-gray-100 text-gray-700
                                                    @endif
                                                ">

                                                    {{ ucfirst($order->payment_status) }}

                                                </span>

                                            </div>

                                            {{-- ORDER STATUS --}}
                                            <div class="flex items-center gap-2">

                                                <h1 class="text-lg text-[#0b1e33]">
                                                    Order Status:
                                                </h1>

                                                <span class="px-3 py-1 rounded-full text-xs font-medium

                                                    @if($order->status == 'delivered')
                                                        bg-green-100 text-green-700
                                                    @elseif($order->status == 'pending')
                                                        bg-yellow-100 text-yellow-700
                                                    @elseif($order->status == 'processing')
                                                        bg-blue-100 text-blue-700
                                                    @elseif($order->status == 'cancelled')
                                                        bg-red-100 text-red-700
                                                    @else
                                                        bg-gray-100 text-gray-700
                                                    @endif
                                                ">

                                                    {{ ucfirst($order->status) }}

                                                </span>

                                            </div>

                                        </div>

                                        <div class="flex flex-wrap items-center gap-4 text-sm text-[#475569]">

                                            <span>
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $order->created_at->format('F d, Y') }}
                                            </span>

                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $order->created_at->format('h:i A') }}
                                            </span>

                                        </div>

                                    </div>

                                    <div class="text-right">

                                        <div class="text-sm text-[#475569] mb-1">
                                            Total Amount
                                        </div>

                                        <div class="text-2xl font-bold text-[#f97316]">
                                            Rs. {{ number_format($order->total_amount, 2) }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- ORDER ITEMS -->
                            <div class="divide-y divide-gray-100">

                                @foreach($order->items as $item)

                                    <div class="p-5 hover:bg-[#fafafa] transition-colors">

                                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">

                                            {{-- PRODUCT IMAGE --}}
                                            <div class="md:w-24 flex-shrink-0">

                                                @php
                                                    $image = $item->product->images[0] ?? null;
                                                @endphp

                                                <img
                                                    src="{{ $image ? asset(Storage::url($image)) : 'https://via.placeholder.com/80x80' }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-20 h-20 object-cover rounded-lg"
                                                >

                                            </div>

                                            {{-- PRODUCT INFO --}}
                                            <div class="flex-grow">

                                                <h6 class="font-semibold text-[#0f172a] text-lg mb-1">
                                                    {{ $item->product->name }}
                                                </h6>

                                                <p class="text-sm text-[#475569] mb-2 line-clamp-2">
                                                    {!! Str::limit($item->product->description, 80) !!}
                                                </p>

                                            </div>

                                            {{-- QUANTITY --}}
                                            <div class="md:w-32 text-center">

                                                <div class="text-sm text-[#475569]">
                                                    Quantity
                                                </div>

                                                <div class="font-bold text-[#0f172a] text-lg">
                                                    {{ $item->qty }}
                                                </div>

                                            </div>

                                            {{-- UNIT PRICE --}}
                                            <div class="md:w-32 text-center">

                                                <div class="text-sm text-[#475569]">
                                                    Unit Price
                                                </div>

                                                <div class="font-bold text-[#0f172a] text-lg">
                                                    Rs. {{ number_format($item->amount, 2) }}
                                                </div>

                                            </div>

                                            {{-- SUBTOTAL --}}
                                            <div class="md:w-36 text-center">

                                                <div class="text-sm text-[#475569]">
                                                    Subtotal
                                                </div>

                                                <div class="font-bold text-[#f97316] text-xl">
                                                    Rs. {{ number_format($item->amount * $item->qty, 2) }}
                                                </div>

                                            </div>

                                            {{-- REVIEW BUTTON --}}
                                            
                                            @if($order->status == 'delivered')

                                                <div class="md:w-auto">

                                                    @php
                                                        $review = \App\Models\Review::where('user_id', auth()->id())
                                                            ->where('product_id', $item->product_id)
                                                            ->first();
                                                    @endphp

                                                    {{-- IF PRODUCT NOT REVIEWED --}}
                                                    @if(!$review)

                                                        <a href="{{ route('reviews.create', [
                                                                'product' => $item->product_id,
                                                                'order' => $order->id
                                                            ]) }}"
                                                        class="btn-rate inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-medium text-sm">

                                                            <i class="fas fa-star"></i>
                                                            Rate Product

                                                        </a>

                                                    {{-- IF PRODUCT ALREADY REVIEWED --}}
                                                    @else

                                                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 min-w-[220px]">

                                                            {{-- STARS --}}
                                                            <div class="flex items-center gap-1 mb-2">

                                                                @for($i = 1; $i <= 5; $i++)

                                                                    <i class="fas fa-star
                                                                        {{ $i <= $review->rating
                                                                            ? 'text-yellow-400'
                                                                            : 'text-gray-300'
                                                                        }}">
                                                                    </i>

                                                                @endfor

                                                            </div>

                                                            {{-- COMMENT --}}
                                                            <p class="text-sm text-[#334155] leading-relaxed mb-2">
                                                                {{ $review->comment }}
                                                            </p>

                                                            {{-- REVIEWED BADGE --}}
                                                            <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700">

                                                                <i class="fas fa-check-circle"></i>
                                                                Reviewed

                                                            </span>

                                                        </div>

                                                    @endif

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <!-- ORDER FOOTER -->
                            <div class="bg-gradient-to-r from-[#f8fafc] to-white p-5 border-t border-gray-100">

                                <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                                    <div class="flex gap-4">

                                        @if($order->payment_status == 'Pending')

                                            <a href="{{ route('khalti.initiate', $order->id) }}"
                                               class="btn-primary inline-flex text-sm px-6 py-2">

                                                <i class="fas fa-credit-card mr-2"></i>
                                                Complete Payment

                                            </a>

                                        @endif

                                        <button onclick="window.print()"
                                                class="text-[#0b1e33] border-2 border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition px-4 py-2">

                                            <i class="fas fa-print mr-2"></i>
                                            Print Order

                                        </button>

                                    </div>

                                    <div class="text-left">

                                        <div class="text-xs text-[#475569]">
                                            Order Total
                                        </div>

                                        <div class="text-xl font-bold text-[#0b1e33]">
                                            Rs. {{ number_format($order->total_amount, 2) }}
                                        </div>

                                    </div>

                                    <div>
                                        <span class="font-bold">
                                            {{ $order->dokan->name }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- PAGINATION --}}
                @if(method_exists($orders, 'links'))

                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>

                @endif

                {{-- CONTINUE SHOPPING --}}
                <div class="mt-8 text-center">

                    <a href="{{ route('products') }}"
                       class="inline-flex items-center gap-2 text-[#0b1e33] hover:text-[#f97316] transition font-medium">

                        <i class="fas fa-arrow-left"></i>
                        Continue Shopping

                    </a>

                </div>

            @endif

        </div>
    </div>

    <style>

        .shadow-card {
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.05),
                        0 8px 15px -6px rgba(0,0,0,0.02);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .decorative-line {
            height: 4px;
            width: 65px;
            background: #f97316;
            border-radius: 5px;
            margin: 0.6rem 0 1.2rem 0;
        }

        .btn-primary {
            background: #f97316;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 18px -6px rgba(249,115,22,0.35);
        }

        .btn-primary:hover {
            background: #ea580c;
            transform: translateY(-2px);
        }

        .btn-rate:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(234,179,8,0.3);
        }

        @media print {

            .navbar,
            .footer,
            .btn-primary,
            button:not(.no-print) {
                display: none !important;
            }

            body {
                background: white;
            }

            .container {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .shadow-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

        }

    </style>

</x-frontend-layout>