<x-frontend-layout>
    <main class="container section-gap">
    
    <!-- Intro for Vendor Registration -->
    <div class="mb-10 md:mb-14 flex flex-col md:flex-row md:items-end md:justify-between">
      <div>
        <div class="flex items-center gap-2 mb-2">
          <span style="background: rgba(16,185,129,0.12); color:#0f766e; padding:0.3rem 1rem; border-radius:2rem; font-weight:500;">
            <i class="fas fa-store-alt"></i> Dokan Partner
          </span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-[var(--color-primary)] leading-tight">
          Join <span style="color:var(--color-accent);">Saroj Hub</span> as a vendor
        </h1>
        <div class="decorative-line"></div>
        <p class="text-lg text-[var(--color-text-light)] max-w-2xl">
          Register your dokan and get a dedicated dashboard. After approval, add products, manage inventory, and start selling.
        </p>
      </div>
      <div class="hidden md:block text-5xl text-[var(--color-accent)] opacity-80">
        <i class="fas fa-store"></i>
      </div>
    </div>

    <!-- Registration Card (form) -->
    <div class="register-card p-6 md:p-10 w-full max-w-5xl mx-auto">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-7 bg-amber-50/70 border border-amber-200/80 rounded-2xl px-5 py-3 text-sm">
        <div class="flex items-center gap-2 text-amber-800"> 
          <i class="fas fa-info-circle text-amber-600"></i>
          <span><strong>Approval required:</strong> Our team reviews your dokan. Dashboard access within 24-48 hours.</span>
        </div>
      </div>

      <form id="vendorForm" action="{{route('dokan_registration')}}" method="POST" class="space-y-7">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label><i class="fas fa-user-circle mr-1 text-[var(--color-accent)]"></i> Dokan / Owner Name</label>
            <input type="text" name="name" placeholder="e.g., Himalayan Grocers" class="input-field" value="{{old('name')}}">
            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label><i class="fas fa-envelope mr-1 text-[var(--color-accent)]"></i> Email address</label>
            <input type="email" name="email" placeholder="dokan@email.com" class="input-field" value="{{old('email')}}">
            @error('email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div>
          <label><i class="fas fa-phone-alt mr-1 text-[var(--color-accent)]"></i> Contact Number</label>
          <input type="tel" name="contact_no" placeholder="+977 98XXXXXXXX" class="input-field" value="{{old('contact_no')}}">
          @error('contact_no')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
          <label><i class="fas fa-pen mr-1 text-[var(--color-accent)]"></i> Message (optional)</label>
          <textarea name="message" rows="4" placeholder="Tell us about your dokan, location..." class="input-field resize-none">{{old('message')}}</textarea>
          @error('message')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap items-center gap-4 bg-slate-50 p-4 rounded-xl border">
          <span class="text-sm font-medium"><i class="fas fa-chart-line text-emerald-600"></i> Your future dashboard:</span>
          <span class="bg-white px-3 py-1.5 rounded-full text-xs shadow-sm"><i class="fas fa-box text-orange-500"></i> Add Products</span>
          <span class="bg-white px-3 py-1.5 rounded-full text-xs shadow-sm"><i class="fas fa-tags text-blue-500"></i> Inventory</span>
          <span class="bg-white px-3 py-1.5 rounded-full text-xs shadow-sm"><i class="fas fa-chart-bar text-purple-500"></i> Sales Stats</span>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t">
          <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Submit Registration</button>
          <button type="button" class="btn-outline" onclick="alert('Learn more about Saroj Hub vendor program.')"><i class="far fa-question-circle"></i> How it works</button>
        </div>
      </form>
    </div>


    <!-- Product Card (form) -->
    <section class="py-12">
        <div class="container mx-auto px-4">

          <!-- Heading -->
          <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900">
              Latest Products
            </h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto my-3 rounded"></div>
            <p class="text-slate-500">
              Discover our newest arrivals
            </p>
          </div>

          <!-- Product Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($products as $product)
              <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden">

                <!-- Image -->                <div class="h-80 bg-slate-100 overflow-hidden relative">
                  <img
                    src="{{ asset(Storage::url($product->images[0])) }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover hover:scale-105 transition duration-300"
                  >

                  @if ($product->discount>0)
                    <span class="absolute top-4 right-0 px-6 text-white bg-red-500 p-2">{{ $product->discount}}%  </span>
                  @endif

                </div>

                <!-- Content -->
                <div class="p-5">
                  <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-1">
                    {{ $product->name }}
                  </h3>

                  <div class="flex items-baseline gap-3 mb-6">
                        @if ($product->discount > 0)
                            <span class=" font-bold text-[var(--color-accent)]">
                                Rs. {{ number_format($product->price - ($product->discount * $product->price) / 100, 2) }}
                            </span>
                            <span class=" text-slate-400 line-through">
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

                  <p class="text-slate-700/60  font-semibold mb-4">
                  by  {{ $product->dokan->name }}
                  </p>

                  

                  <!-- Buttons -->
                  <div class="flex gap-3">
                    <a class="w-[50%] text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-xl transition" href="{{route('product',$product->slug)}}">
                      <button class="">
                        View
                      </button>
                    </a>

                    <button class="flex-1 border border-slate-300 hover:bg-slate-900 hover:text-white text-slate-700 font-semibold py-2 rounded-xl transition">
                      Cart
                    </button>
                  </div>
                </div>

              </div>
            @endforeach

          </div>

        </div>
    </section>

  </main>
</x-frontend-layout>