<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\EloquentProductRepository;
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use App\Repositories\Eloquent\EloquentWarehouseRepository;
use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Repositories\Eloquent\EloquentLocationRepository;
use App\Repositories\Contracts\InventoryRepositoryInterface;
use App\Repositories\Eloquent\EloquentInventoryRepository;
use App\Repositories\Contracts\InboundOrderRepositoryInterface;
use App\Repositories\Eloquent\EloquentInboundOrderRepository;
use App\Repositories\Contracts\InboundItemRepositoryInterface;
use App\Repositories\Eloquent\EloquentInboundItemRepository;
use App\Repositories\Contracts\OutboundOrderRepositoryInterface;
use App\Repositories\Eloquent\EloquentOutboundOrderRepository;
use App\Repositories\Contracts\OutboundItemRepositoryInterface;
use App\Repositories\Eloquent\EloquentOutboundItemRepository;
use App\Repositories\Contracts\ShippingLogRepositoryInterface;
use App\Repositories\Eloquent\EloquentShippingLogRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(WarehouseRepositoryInterface::class, EloquentWarehouseRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, EloquentLocationRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, EloquentInventoryRepository::class);
        $this->app->bind(InboundOrderRepositoryInterface::class, EloquentInboundOrderRepository::class);
        $this->app->bind(InboundItemRepositoryInterface::class, EloquentInboundItemRepository::class);
        $this->app->bind(OutboundOrderRepositoryInterface::class, EloquentOutboundOrderRepository::class);
        $this->app->bind(OutboundItemRepositoryInterface::class, EloquentOutboundItemRepository::class);
        $this->app->bind(ShippingLogRepositoryInterface::class, EloquentShippingLogRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
