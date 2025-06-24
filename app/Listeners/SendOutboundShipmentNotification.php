<?php

namespace App\Listeners;

use App\Events\OutboundOrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOutboundShipmentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OutboundOrderShipped $event): void
    {
        Log::info("Outbound order {$event->outboundOrder->order_number} shipped. Tracking: {$event->shippingData['tracking_number']}. Sending notification...");
        // Here you would implement actual notification logic, e.g.,
        // Mail::to($event->outboundOrder->customer_email)->send(new OutboundOrderShippedMail($event->outboundOrder, $event->shippingData));
    }
}
