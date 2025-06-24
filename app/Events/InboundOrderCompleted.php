<?php

namespace App\Events;

use App\Models\InboundOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InboundOrderCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public InboundOrder $inboundOrder;

    /**
     * Create a new event instance.
     */
    public function __construct(InboundOrder $inboundOrder)
    {
        $this->inboundOrder = $inboundOrder;
    }
}
