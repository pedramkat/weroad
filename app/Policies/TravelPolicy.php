<?php

namespace App\Policies;

use App\Models\Travel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TravelPolicy
{
    /**
     * Only Admin can access to Travels
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        return $user->roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Travel $travel): void
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Travel $travel): void
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Travel $travel): void
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Travel $travel): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Travel $travel): void
    {
        //
    }
}
