<x-frontend-layout>
    <main class="container section-gap">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span style="background: rgba(249,115,22,0.12); color: #f97316; padding: 0.5rem 1.2rem; border-radius: 2rem; font-weight: 500; font-size: 0.85rem;">
                        <i class="fas fa-lock"></i> Secure Access
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[var(--color-primary)]">
                    Welcome to Saroj<span style="color:var(--color-accent);">Hub</span>
                </h1>
                <div class="decorative-line pl-[450px]"></div>
                <p class="text-[var(--color-text-light)]">
                    Sign in to your SarojHub account
                </p>
            </div>

            <!-- Login Card -->
            <div class="register-card p-6 md:p-8">
                <!-- Session Status -->
                @if(session('status'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                {{-- <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-[var(--color-primary)]">
                            <i class="fas fa-envelope mr-1 text-[var(--color-accent)]"></i> Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                               placeholder="your@email.com" class="input-field">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-[var(--color-primary)]">
                            <i class="fas fa-lock mr-1 text-[var(--color-accent)]"></i> Password
                        </label>
                        <input type="password" name="password" required 
                               placeholder="••••••••" class="input-field">
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <label class="flex items-center gap-2 text-sm text-[var(--color-text-light)] cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[var(--color-accent)] focus:ring-[var(--color-accent)]">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-[var(--color-accent)] hover:underline">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full justify-center">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form> --}}

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[var(--color-border)]"></div>
                    </div>
                    {{-- <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-[var(--color-text-light)]">Continue with</span>
                    </div> --}}
                </div>

                <!-- Google Sign In Button -->
                <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-[var(--color-border)] hover:border-[var(--color-accent)] text-[var(--color-text)] font-semibold py-3 rounded-xl transition-all duration-200 hover:shadow-md">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Sign in with Google</span>
                </a>

                
            </div>

            
        </div>
    </main>
</x-frontend-layout>