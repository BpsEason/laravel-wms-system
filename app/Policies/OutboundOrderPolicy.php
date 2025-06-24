<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OutboundOrder;
use Illuminate\Auth\Access\Response;

class OutboundOrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any outbound orders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('view outbound order');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create outbound order');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('update outbound order');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('delete outbound order');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('restore outbound order');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('force delete outbound order');
    }

    /**
     * Determine whether the user can pick items for an outbound order.
     */
    public function pickItems(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('pick outbound order items');
    }

    /**
     * Determine whether the user can ship an outbound order.
     */
    public function shipOrder(User $user, OutboundOrder $outboundOrder): bool
    {
        return $user->hasPermissionTo('ship outbound order');
    }
}
