{{-- resources/views/frontend/products.blade.php --}}
<x-frontend-layout>
    <main class="container section-gap">

        {{-- Page Header --}}
        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[var(--color-primary)] leading-tight">
                All <span style="color:var(--color-accent);">Products</span>
            </h1>
            <div class="decorative-line mx-auto"></div>
            <p class="text-lg text-[var(--color-text-light)] max-w-2xl mx-auto mt-2">
                Discover our amazing collection
            </p>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden group">
                        {{-- Image --}}
                        <a href="{{ route('product', $product->slug) }}">
                            <div class="h-64 bg-slate-100 overflow-hidden relative">
                                <img src="{{ asset(Storage::url($product->images[0] ?? 'placeholder.jpg')) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                
                                @if ($product->discount > 0)
                                    <span class="absolute top-4 right-4 px-3 py-1 bg-red-500 text-white font-bold rounded-full text-xs shadow">
                                        {{ $product->discount }}% OFF
                                    </span>
                                @endif
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="p-4">
                            <a href="{{ route('product', $product->slug) }}">
                                <h3 class="font-bold text-lg text-slate-800 mb-2 line-clamp-1 hover:text-[var(--color-accent)] transition">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            {{-- Price --}}
                            <div class="flex items-baseline gap-2 mb-3">
                                @if ($product->discount > 0)
                                    <span class="font-bold text-[var(--color-accent)] text-xl">
                                        Rs. {{ number_format($product->price - ($product->discount * $product->price) / 100, 2) }}
                                    </span>
                                    <span class="text-slate-400 text-sm line-through">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </span>
                                @else
                                    <span class="font-bold text-[var(--color-accent)] text-xl">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Short Description --}}
                            <p class="text-slate-600 text-sm line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($product->description), 100) }}
                            </p>

                            {{-- Buttons --}}
                            <div class="flex gap-3">
                                <a href="{{ route('product', $product->slug) }}" 
                                   class="flex-1 text-center bg-[var(--color-accent)] hover:bg-[var(--color-accent)]/80 text-white font-semibold py-2 rounded-xl transition">
                                    View Details
                                </a>
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="w-10 h-10 border border-slate-300 hover:bg-[var(--color-accent)] hover:text-white rounded-xl transition">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- No Products Found --}}
            <div class="text-center py-16">
                <i class="fas fa-box-open text-6xl text-slate-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-slate-600">No products found</h3>
                <p class="text-slate-400 mt-2">Check back later for new products!</p>
            </div>
        @endif

    </main>

    <script>
        function addToCart(productId) {
            alert('Product ' + productId + ' added to cart!');
            // You can integrate your cart logic here
        }
    </script>

    <style>
        .decorative-line {
            width: 60px;
            height: 4px;
            background: var(--color-accent);
            border-radius: 2px;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-frontend-layout>