<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\CalendarServiceInterface;
use App\Services\Calendar\CalendarService;

class ServiceBindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CalendarServiceInterface::class, CalendarService::class);
    }

    public function boot(): void
    {
        //
    }
}
