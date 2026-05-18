<header class="navbar">
    <div class="container nav-container">
      <!-- Logo -->
      <a href="#" class="logo">
        <i class="fas fa-shopping-bag"></i> Saroj<span style="color:var(--color-accent);">Hub</span>
      </a>

      <!-- Navigation links (Home, Categories, Shop, Deals, About, Contact) -->
      <ul class="nav-links">
        <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{route('dokanRegister')}}"><i class="fas fa-info-circle"></i>Register Dokan </a></li>
        <li><a href="{{route('products')}}"><i class="fas fa-store"></i> Shop</a></li>
        <li><a href="{{route('deals')}}"><i class="fas fa-tags"></i> Deals</a></li>
        <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
      </ul>

      <!-- Right side icons (search, wishlist, cart, user) -->
      <div class="nav-actions">
        <button class="icon-btn" aria-label="Search"><i class="fas fa-search"></i></button>
        <button class="icon-btn" aria-label="Cart"><i class="fas fa-shopping-cart"></i><span class="badge">5</span></button>
        @if (!Auth::guard('web')->user())
          <a href="{{route('login')}}" class="bg-(--color-accent)/90 p-2 text-white border hover:bg-(--color-accent) rounded-lg font-bold " aria-label="Account">Sign in</a>
        @else
          <form action="{{route('logout')}}" method="post">
            @csrf
            @method('delete')
            <button class="bg-(--color-accent)/90 p-2 text-white border hover:bg-(--color-accent) rounded-lg font-bold " type="submit">Log Out</button>
          </form>
        @endif
        
      </div>
    </div>
  </header>