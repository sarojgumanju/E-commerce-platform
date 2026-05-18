<x-frontend-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-emerald-50 to-teal-50 overflow-hidden">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4">
                    Welcome to 
                    <span class="text-emerald-600">SarojHub</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8">
                    Your one-stop destination for quality products from trusted vendors
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products') }}" class="inline-flex items-center justify-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition duration-300">
                        <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                    </a>
                    <a href="{{ route('dokanRegister') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg border border-gray-300 transition duration-300">
                        <i class="fas fa-store mr-2"></i> Become a Vendor
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent"></div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Featured Products
                </h2>
                <div class="w-20 h-1 bg-emerald-500 mx-auto rounded-full"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Discover our handpicked selection of premium products
                </p>
            </div>

            <!-- Products Grid -->
            @if(isset($products) && count($products) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products->take(8) as $product)
                        <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <!-- Product Image -->
                            <div class="relative h-64 bg-gray-100 overflow-hidden">
                                <img 
                                    src="{{ asset(Storage::url($product->images[0] ?? 'default-image.jpg')) }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                >
                                @if($product->discount > 0)
                                    <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        -{{ $product->discount }}%
                                    </span>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 text-lg mb-1 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-3">
                                    by {{ $product->dokan->name ?? 'Vendor' }}
                                </p>
                                
                                <!-- Price -->
                                <div class="flex items-baseline gap-2 mb-4">
                                    @if($product->discount > 0)
                                        <span class="text-xl font-bold text-emerald-600">
                                            Rs. {{ number_format($product->price - ($product->discount * $product->price) / 100, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">
                                            Rs. {{ number_format($product->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-xl font-bold text-emerald-600">
                                            Rs. {{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('product', $product->slug) }}" 
                                       class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg transition">
                                        View Details
                                    </a>
                                    <button class="p-2 border border-gray-300 rounded-lg hover:bg-emerald-600 hover:border-emerald-600 hover:text-white transition group">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Products Button -->
                <div class="text-center mt-12">
                    <a href="{{ route('products') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg transition">
                        View All Products
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No products available yet.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">
                    Why Choose SarojHub?
                </h2>
                <div class="w-20 h-1 bg-emerald-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-2xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">Quick and reliable delivery across all regions</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure Payments</h3>
                    <p class="text-gray-600">100% secure payment gateway protection</p>
                </div>

                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Dedicated customer support team always ready</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-16 bg-gradient-to-r from-emerald-600 to-teal-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ready to Start Selling?
            </h2>
            <p class="text-emerald-100 mb-8 max-w-2xl mx-auto">
                Join thousands of vendors who trust SarojHub to grow their business
            </p>
            <a href="{{ route('dokanRegister') }}" class="inline-flex items-center px-8 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                Register as Vendor
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>
</x-frontend-layout>