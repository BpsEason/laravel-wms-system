<?php

namespace App\Listeners;

use App\Events\InboundOrderCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendInboundCompletionNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(InboundOrderCompleted $event): void
    {
        Log::info("Inbound order {$event->inboundOrder->order_number} completed. Sending notification...");
        // Here you would implement actual notification logic, e.g.,
        // Mail::to('admin@example.com')->send(new InboundOrderCompletedMail($event->inboundOrder));
        // Push notification, etc.
    }
}
