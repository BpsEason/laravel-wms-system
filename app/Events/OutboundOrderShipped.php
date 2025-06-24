<?php

namespace App\Events;

use App\Models\OutboundOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OutboundOrderShipped
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public OutboundOrder $outboundOrder;
    public array $shippingData;

    /**
     * Create a new event instance.
     */
    public function __construct(OutboundOrder $outboundOrder, array $shippingData)
    {
        $this->outboundOrder = $outboundOrder;
        $this->shippingData = $shippingData;
    }
}
