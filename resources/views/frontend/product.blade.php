{{-- resources/views/frontend/product.blade.php --}}
<x-frontend-layout>
    <main class="container section-gap">

        {{-- Back Navigation --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-[var(--color-text-light)] hover:text-[var(--color-accent)] transition">
                <i class="fas fa-arrow-left"></i>
                <span>Back to products</span>
            </a>
        </div>

        {{-- Product Detail Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-10">

                {{-- Product Images Gallery --}}
                <div>
                    {{-- Main Image --}}
                    <div class="bg-slate-100 rounded-2xl overflow-hidden mb-4 relative">
                        <img id="mainProductImage"
                             src="{{ asset(Storage::url($product->images[0] ?? 'placeholder.jpg')) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-auto object-cover hover:scale-105 transition duration-300">

                        @if ($product->discount > 0)
                            <span class="absolute top-4 right-4 px-4 py-1.5 bg-red-500 text-white font-bold rounded-full text-sm shadow">
                                {{ $product->discount }}% OFF
                            </span>
                        @endif
                    </div>

                    {{-- Thumbnail Gallery --}}
                    @if(count($product->images) > 1)
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            @foreach($product->images as $index => $image)
                                <div class="cursor-pointer rounded-lg overflow-hidden border-2 {{ $index == 0 ? 'border-[var(--color-accent)]' : 'border-transparent' }} hover:border-[var(--color-accent)] transition"
                                     onclick="changeMainImage('{{ asset(Storage::url($image)) }}', this)">
                                    <img src="{{ asset(Storage::url($image)) }}"
                                         alt="{{ $product->name }} thumbnail"
                                         class="w-20 h-20 object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div>
                    {{-- Vendor Badge --}}
                    <div class="mb-3">
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-store"></i> {{ $product->dokan->name ?? 'Saroj Hub Vendor' }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-[var(--color-primary)] mb-4">
                        {{ $product->name }}
                    </h1>

                    {{-- Price Section --}}
                    <div class="flex items-baseline gap-3 mb-6">
                        @if ($product->discount > 0)
                            <span class="text-3xl font-bold text-[var(--color-accent)]">
                                Rs. {{ number_format($product->price - ($product->discount * $product->price) / 100, 2) }}
                            </span>
                            <span class="text-xl text-slate-400 line-through">
                                Rs. {{ number_format($product->price, 2) }}
                            </span>
                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-sm font-semibold">
                                Save {{ $product->discount }}%
                            </span>
                        @else
                            <span class="text-3xl font-bold text-[var(--color-accent)]">
                                Rs. {{ number_format($product->price, 2) }}
                            </span>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-slate-800 mb-2">Product Description</h3>
                        <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                            {!! $product->description !!}
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-200">
                        <button class="btn-primary flex-1 justify-center" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn-outline flex-1 justify-center" onclick="alert('Wishlist feature coming soon!')">
                            <i class="far fa-heart"></i> Save to Wishlist
                        </button>
                    </div>

                    {{-- Additional Info --}}
                    <div class="mt-6 p-4 bg-slate-50 rounded-xl text-sm text-slate-500">
                        <div class="flex items-center gap-4 flex-wrap">
                            <span><i class="fas fa-truck"></i> Free shipping on orders over Rs. 5000</span>
                            <span><i class="fas fa-undo-alt"></i> 7-day return policy</span>
                            <span><i class="fas fa-shield-alt"></i> Secure checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products Section (Optional) --}}
        @if(isset($relatedProducts) && count($relatedProducts) > 0)
            <section class="py-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-extrabold text-slate-900">You May Also Like</h2>
                    <a href="{{ route('products') }}" class="text-[var(--color-accent)] hover:underline text-sm">View All →</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
                            <a href="{{ route('product', $related->slug) }}">
                                <div class="h-48 bg-slate-100 overflow-hidden">
                                    <img src="{{ asset(Storage::url($related->images[0] ?? 'placeholder.jpg')) }}"
                                         alt="{{ $related->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-slate-800 line-clamp-1">{{ $related->name }}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($related->discount > 0)
                                            <span class="font-bold text-[var(--color-accent)]">
                                                Rs. {{ number_format($related->price - ($related->discount * $related->price) / 100, 0) }}
                                            </span>
                                            <span class="text-xs text-slate-400 line-through">
                                                Rs. {{ number_format($related->price, 0) }}
                                            </span>
                                        @else
                                            <span class="font-bold text-[var(--color-accent)]">
                                                Rs. {{ number_format($related->price, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    <script>
        function changeMainImage(imageUrl, thumbnailElement) {
            // Update main image
            document.getElementById('mainProductImage').src = imageUrl;

            // Update active border on thumbnails
            const thumbnails = document.querySelectorAll('.grid.grid-cols-2 .cursor-pointer, .flex.gap-3 .cursor-pointer');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-[var(--color-accent)]');
                thumb.classList.add('border-transparent');
            });
            thumbnailElement.classList.remove('border-transparent');
            thumbnailElement.classList.add('border-[var(--color-accent)]');
        }

        function addToCart(productId) {
            // You can integrate with your cart system here
            alert('Product ' + productId + ' added to cart!');
        }
    </script>

    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-frontend-layout>