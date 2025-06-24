<?php

namespace App\Providers;

use App\Models\InboundOrder;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\OutboundOrder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Policies\InboundOrderPolicy;
use App\Policies\InventoryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\OutboundOrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\WarehousePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Warehouse::class => WarehousePolicy::class,
        Location::class => LocationPolicy::class,
        Inventory::class => InventoryPolicy::class,
        InboundOrder::class => InboundOrderPolicy::class,
        OutboundOrder::class => OutboundOrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Implicitly grant "super-admin" role all permissions
        // This works in the Policy class as well
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
