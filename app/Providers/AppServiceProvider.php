<?php

namespace App\Providers;

use App\Repositories\ConversionRepository;
use App\Repositories\ConversionRepositoryInterface;
use App\Services\ConversionService;
use App\Services\ConversionServiceInterface;
use App\Services\IntegerConverterInterface;
use App\Services\RomanNumeralConverter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ConversionRepositoryInterface::class, ConversionRepository::class);
        $this->app->bind(IntegerConverterInterface::class, RomanNumeralConverter::class);
        $this->app->bind(ConversionServiceInterface::class, ConversionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
