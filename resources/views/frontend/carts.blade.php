<x-frontend-layout>
    <!-- Cart Page Content -->
    <div class="py-8 lg:py-12">
        <div class="container mx-auto px-4" style="width: 86%; max-width: 1400px;">
            
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-[#0b1e33] mb-2">Shopping Cart</h1>
                <div class="decorative-line"></div>
                <p class="text-[#475569] mt-2">Review your items and proceed to checkout</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(empty($cartGroups) || count($cartGroups) == 0)
                <!-- Empty Cart State -->
                <div class="bg-white rounded-2xl shadow-card border border-gray-100 text-center py-16 px-4">
                    <div class="mb-6">
                        <i class="fas fa-shopping-cart text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-[#0f172a] mb-3">Your cart is empty!</h3>
                    <p class="text-[#475569] mb-8">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{route('products')}}" class="btn-primary inline-flex">
                        <i class="fas fa-store mr-2"></i> Start Shopping
                    </a>
                </div>
            @else
                <!-- Cart Groups by Dokan -->
                <div class="space-y-6">
                    @foreach($cartGroups as $group)
                        <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden transition-all hover:shadow-lg">
                            <!-- Dokan Header -->
                            <div class="bg-gradient-to-r from-[#f8fafc] to-white p-5 border-b border-gray-100">
                                <div class="flex justify-between items-start flex-wrap gap-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas fa-store text-[#f97316] text-xl"></i>
                                            <h4 class="text-xl font-bold text-[#0b1e33]">{{ $group['dokan']->name }}</h4>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm">
                                            <span class="text-[#475569]">
                                                <i class="fas fa-envelope mr-1"></i> {{ $group['dokan']->email }}
                                            </span>
                                            <span class="text-[#475569]">
                                                <i class="fas fa-phone mr-1"></i> {{ $group['dokan']->contact_no }}
                                            </span>
                                            {{-- <span class="px-2 py-1 rounded-full text-xs font-medium 
                                                @if($group['dokan']->status == 'approved') bg-green-100 text-green-700
                                                @elseif($group['dokan']->status == 'pending') bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                <i class="fas fa-circle mr-1 text-xs"></i>
                                                {{ ucfirst($group['dokan']->status) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-[#475569]">Total Items</div>
                                        <div class="text-2xl font-bold text-[#f97316]">{{ $group['item_count'] }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cart Items -->
                            <div class="divide-y divide-gray-100">
                                @foreach($group['items'] as $item)
                                    <div class="p-5 hover:bg-[#fafafa] transition-colors">
                                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                                            <!-- Product Image -->
                                            <div class="md:w-24 flex-shrink-0">
                                                @php
                                                    $image = $item->product->images[0] ?? null;
                                                @endphp

                                                <img 
                                                    src="{{ $image ? asset(Storage::url($image)) : 'https://via.placeholder.com/80x80' }}"
                                                    alt="{{ $item->product->name }}"
>
                                            </div>
                                            
                                            <!-- Product Info -->
                                            <div class="flex-grow">
                                                <h6 class="font-semibold text-[#0f172a] text-lg mb-1">{{ $item->product->name }}</h6>
                                                <p class="text-sm text-[#475569] mb-2 line-clamp-2">{!! Str::limit($item->product->description, 80) !!}</p>
                                                @if($item->product->discount > 0)
                                                    <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                                        <i class="fas fa-tag"></i> {{ $item->product->discount }}% OFF
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Price -->
                                            <div class="md:w-32 text-center">
                                                <div class="text-sm text-[#475569]">Unit Price</div>
                                                <div class="font-bold text-[#0f172a] text-lg">Rs. {{ number_format($item->amount, 2) }}</div>
                                                @if($item->product->price > $item->amount)
                                                    <div class="text-xs text-gray-400 line-through">Rs. {{ number_format($item->product->price, 2) }}</div>
                                                @endif
                                            </div>
                                            
                                            <!-- Quantity Update -->
                                            <div class="md:w-36">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="flex items-center justify-between border border-gray-200 rounded-lg overflow-hidden">
                                                        <button type="button" class="qty-decrease hover:bg-gray-300 px-2  py-2 bg-gray-50  transition" data-input="qty_{{ $item->id }}">
                                                            <i class="fas fa-minus text-xs"></i>
                                                        </button>
                                                        <input type="number" name="qty" id="qty_{{ $item->id }}" value="{{ $item->qty }}" min="1" 
                                                               class="w-14 text-center border-0 focus:ring-0 p-2 text-sm">
                                                        <button type="button" onclick="" class="qty-increase hover:bg-gray-300 px-2 py-2 bg-gray-50  transition" data-input="qty_{{ $item->id }}">
                                                            <i class="fas fa-plus text-xs"></i>
                                                        </button>
                                                    </div>
                                                    <button type="submit" class="text-[#f97316] hover:text-[#ea580c] transition">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Subtotal -->
                                            <div class="md:w-32 text-center">
                                                <div class="text-sm text-[#475569]">Subtotal</div>
                                                <div class="font-bold text-[#f97316] text-xl">Rs. {{ number_format($item->amount * $item->qty, 2) }}</div>
                                            </div>
                                            
                                            <!-- Remove Button -->
                                            <div>
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                                        <i class="fas fa-trash-alt text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Dokan Footer with Checkout -->
                            <div class="bg-gradient-to-r from-[#f8fafc] to-white p-5 border-t border-gray-100">
                                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                                    <div>
                                        <div class="text-sm text-[#475569] mb-1">Dokan Subtotal</div>
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-bold text-[#0b1e33]">Rs. {{ number_format($group['subtotal'], 2) }}</span>
                                            <span class="text-sm text-gray-500">({{ $group['item_count'] }} items)</span>
                                        </div>
                                    </div>

                                    <div>
                                        <form action="{{ route('clearDokanCart', $item->dokan_id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-black border-2 rounded-md font-bold hover:text-red-500 transition p-2">
                                                        Clear Cart
                                                    </button>
                                        </form>          
                                    </div>

                                    <form action="{{ route('cart.checkout.dokan', $group['dokan']->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name='total_amt' value="{{ number_format($group['subtotal'], 2) }}"   >
                                        <button type="submit" class="btn-primary inline-flex text-lg px-8 py-3" >
                                            <i class="fas fa-credit-card mr-2"></i> Checkout from {{ $group['dokan']->name }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Cart Total Summary -->
                <div class="mt-8 bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl p-6 border border-orange-100 shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-[#0b1e33] mb-1">Cart Total Summary</h4>
                            <p class="text-sm text-[#475569]">Total amount including all items from all dokans</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-[#475569]">Grand Total</div>
                            <div class="text-3xl font-bold text-[#f97316]">Rs. {{ number_format($cartTotal, 2) }}</div>
                        </div>
                    </div>
                </div>
                 
                <!-- Continue Shopping Button -->
                <div class="mt-6 text-center">
                    <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-[#0b1e33] hover:text-[#f97316] transition font-medium">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>

                <div class="flex items-center justify-center mt-[20px]">
                    <form action="{{ route('clearAllCart') }}" method="POST" >
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="text-black border-2 rounded-md font-bold hover:text-red-500 transition p-2">
                                Clear All Cart
                            </button>
                    </form>          
                </div>                                               
                                       
            @endif
        </div>
    </div>

  
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.qty-decrease').forEach(button => {
                button.addEventListener('click', function () {
                    const inputId = this.getAttribute('data-input');
                    const input = document.getElementById(inputId);

                    if (input && input.value > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                });
            });

            document.querySelectorAll('.qty-increase').forEach(button => {
                button.addEventListener('click', function () {
                    const inputId = this.getAttribute('data-input');
                    const input = document.getElementById(inputId);

                    if (input) {
                        input.value = parseInt(input.value) + 1;
                    }
                });
            });

        });
    </script>

    <style>
        /* Additional custom styles to complement Tailwind */
        .shadow-card {
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.05), 0 8px 15px -6px rgba(0,0,0,0.02);
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 0;
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
            box-shadow: 0 8px 18px -6px rgba(249, 115, 22, 0.35);
        }
        
        .btn-primary:hover {
            background: #ea580c;
            transform: translateY(-2px);
        }
    </style>

</x-frontend-layout>