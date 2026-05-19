<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        View::composer('components.frontend-header', function ($view) {

        $cartGroups = collect();

        if (Auth::check()) {
            $cartGroups = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->groupBy('dokan_id')
                ->map(function ($items) {
                    return [
                        'items' => $items,
                        'item_count' => $items->sum('qty')
                    ];
                });
        }

        $view->with('cartGroups', $cartGroups);
    });
    }
}
