<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*** Repositories injection */
        $this->app->bind('App\Repositories\User\Interfaces\UserInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\Game\Interfaces\GameInterface', 'App\Repositories\Game\GameRepository');

        /*** Services injection */
        $this->app->bind('App\Services\User\Interfaces\UserInterface', 'App\Services\User\UserService');
        $this->app->bind('App\Services\Game\Interfaces\GameInterface', 'App\Services\Game\GameService');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
