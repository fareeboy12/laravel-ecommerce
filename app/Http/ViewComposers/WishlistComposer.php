<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WishlistComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $wishlistCount = Auth::user()->wishlists()->count();
            $view->with('wishlistCount', $wishlistCount);
        } else {
            $view->with('wishlistCount', 0);
        }
    }
}
