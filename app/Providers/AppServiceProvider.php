<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
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
        $this->app->bind('cart.id',function(){
            $id = Cookie::get('cart_id');
            if (!$id) {
              $id = Str::uuid();
              Cookie::queue('cart_id', $id, 60 * 24 * 30);
            }
          return $id;
        });
        
         
    }
    
    
}
