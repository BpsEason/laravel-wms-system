<?php

namespace App\Policies;

use App\Models\User;
use App\Models\${MODEL};
use Illuminate\Auth\Access\Response;

class ${MODEL}Policy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any ${MODEL,,}s');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ${MODEL} $${MODEL,,}): bool
    {
        return $user->hasPermissionTo('view ${MODEL,,}');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create ${MODEL,,}');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ${MODEL} $${MODEL,,}): bool
    {
        return $user->hasPermissionTo('update ${MODEL,,}');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ${MODEL} $${MODEL,,}): bool
    {
        return $user->hasPermissionTo('delete ${MODEL,,}');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ${MODEL} $${MODEL,,}): bool
    {
        return $user->hasPermissionTo('restore ${MODEL,,}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ${MODEL} $${MODEL,,}): bool
    {
        return $user->hasPermissionTo('force delete ${MODEL,,}');
    }
}
