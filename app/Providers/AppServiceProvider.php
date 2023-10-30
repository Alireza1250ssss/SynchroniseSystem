<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        // deifne macro http client method for calls to third party system endpoints
        Http::macro('thirdPartySystem',function(){
            return Http::withHeaders([
                'Authorization' => 'example-access-token'
            ])->baseUrl('https://api.third-party-system.com/webhook/');
        });
    }
}
