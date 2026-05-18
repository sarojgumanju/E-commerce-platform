<header class="navbar">
    <div class="container nav-container">
      <!-- Logo -->
      <a href="#" class="logo">
        <i class="fas fa-shopping-bag"></i> Saroj<span style="color:var(--color-accent);">Hub</span>
      </a>

      <!-- Navigation links (Home, Categories, Shop, Deals, About, Contact) -->
      <ul class="nav-links">
        <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{route('products')}}"><i class="fas fa-store"></i> Shop</a></li>
        <li><a href="{{route('deals')}}"><i class="fas fa-tags"></i> Deals</a></li>
        <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>
        <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
      </ul>

      <!-- Right side icons (search, wishlist, cart, user) -->
      <div class="nav-actions">
        <button class="icon-btn" aria-label="Search"><i class="fas fa-search"></i></button>
        <button class="icon-btn" aria-label="Wishlist"><i class="far fa-heart"></i><span class="badge">3</span></button>
        <button class="icon-btn" aria-label="Cart"><i class="fas fa-shopping-cart"></i><span class="badge">5</span></button>
        <button class="icon-btn" aria-label="Account"><i class="far fa-user-circle"></i></button>
      </div>
    </div>
  </header>