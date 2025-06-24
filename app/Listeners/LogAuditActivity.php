<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\ModelCreated;
use Illuminate\Database\Events\ModelDeleted;
use Illuminate\Database\Events\ModelUpdated;
use App\Events\InboundOrderCompleted;
use App\Events\OutboundOrderShipped;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class LogAuditActivity implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param object $event
     */
    public function handle(object $event): void
    {
        $userId = Auth::id();
        $ipAddress = Request::ip();
        $userAgent = Request::header('User-Agent');
        $oldValues = null;
        $newValues = null;
        $auditable = null;
        $eventType = null;

        if ($event instanceof ModelCreated) {
            $auditable = $event->model;
            $eventType = 'created';
            $newValues = $auditable->toArray();
        } elseif ($event instanceof ModelUpdated) {
            $auditable = $event->model;
            $eventType = 'updated';
            $oldValues = $auditable->getOriginal();
            $newValues = $auditable->getChanges();
        } elseif ($event instanceof ModelDeleted) {
            $auditable = $event->model;
            $eventType = 'deleted';
            $oldValues = $auditable->toArray();
        } elseif ($event instanceof InboundOrderCompleted) {
            $auditable = $event->inboundOrder;
            $eventType = 'inbound_completed';
            $newValues = ['status' => $auditable->status];
        } elseif ($event instanceof OutboundOrderShipped) {
            $auditable = $event->outboundOrder;
            $eventType = 'outbound_shipped';
            $newValues = ['status' => $auditable->status, 'shipping_data' => $event->shippingData];
        }

        if ($auditable instanceof Model && $eventType) {
            // Avoid logging audit_logs model itself to prevent infinite loop
            if ($auditable instanceof AuditLog) {
                return;
            }

            AuditLog::create([
                'user_id' => $userId,
                'event' => $eventType,
                'auditable_id' => $auditable->id,
                'auditable_type' => $auditable::class,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
            Log::info("AuditLog recorded: {$eventType} for {$auditable::class}:{$auditable->id}");
        }
    }
}
