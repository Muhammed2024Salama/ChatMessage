<?php

namespace App\Providers;

use App\Interface\AuthInterface;
use App\Interface\ChatMessageInterface;
use App\Repository\AuthRepository;
use App\Repository\ChatMessageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatMessageInterface::class, ChatMessageRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
