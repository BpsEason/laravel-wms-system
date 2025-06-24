<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InboundOrder;
use Illuminate\Auth\Access\Response;

class InboundOrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any inbound orders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('view inbound order');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create inbound order');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('update inbound order');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('delete inbound order');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('restore inbound order');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('force delete inbound order');
    }

    /**
     * Determine whether the user can receive items for an inbound order.
     */
    public function receiveItems(User $user, InboundOrder $inboundOrder): bool
    {
        return $user->hasPermissionTo('receive inbound order items');
    }
}
