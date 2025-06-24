<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Implementations\ProductService;
use App\Services\Contracts\WarehouseServiceInterface;
use App\Services\Implementations\WarehouseService;
use App\Services\Contracts\LocationServiceInterface;
use App\Services\Implementations\LocationService;
use App\Services\Contracts\InventoryServiceInterface;
use App\Services\Implementations\InventoryService;
use App\Services\Contracts\InboundOrderServiceInterface;
use App\Services\Implementations\InboundOrderService;
use App\Services\Contracts\OutboundOrderServiceInterface;
use App\Services\Implementations\OutboundOrderService;


class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(WarehouseServiceInterface::class, WarehouseService::class);
        $this->app->bind(LocationServiceInterface::class, LocationService::class);
        $this->app->bind(InventoryServiceInterface::class, InventoryService::class);
        $this->app->bind(InboundOrderServiceInterface::class, InboundOrderService::class);
        $this->app->bind(OutboundOrderServiceInterface::class, OutboundOrderService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
