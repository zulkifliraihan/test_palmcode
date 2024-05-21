<?php

namespace App\Providers;

use App\Http\Repository\BookingRepository\BookingInterface;
use App\Http\Repository\BookingRepository\BookingRepository;
use App\Http\Repository\CountryRepository\CountryInterface;
use App\Http\Repository\CountryRepository\CountryRepository;
use App\Http\Repository\UserRepository\UserInterface;
use App\Http\Repository\UserRepository\UserRepository;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(BookingInterface::class, BookingRepository::class);
        $this->app->bind(CountryInterface::class, CountryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'user' => User::class,
            'booking' => Booking::class,
        ]);
    }
}
