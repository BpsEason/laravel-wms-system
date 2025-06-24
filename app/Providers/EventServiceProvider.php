<?php

namespace App\Providers;

use App\Events\InboundOrderCompleted;
use App\Events\OutboundOrderShipped;
use App\Listeners\LogAuditActivity;
use App\Listeners\SendInboundCompletionNotification;
use App\Listeners\SendOutboundShipmentNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Events\ModelCreated;
use Illuminate\Database\Events\ModelDeleted;
use Illuminate\Database\Events\ModelUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        InboundOrderCompleted::class => [
            SendInboundCompletionNotification::class,
            LogAuditActivity::class,
        ],
        OutboundOrderShipped::class => [
            SendOutboundShipmentNotification::class,
            LogAuditActivity::class,
        ],
        ModelCreated::class => [
            LogAuditActivity::class,
        ],
        ModelUpdated::class => [
            LogAuditActivity::class,
        ],
        ModelDeleted::class => [
            LogAuditActivity::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
