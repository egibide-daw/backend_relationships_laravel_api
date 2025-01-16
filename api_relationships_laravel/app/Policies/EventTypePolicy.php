<?php

namespace App\Policies;

use App\Models\EventType;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class EventTypePolicy
{
    public function before(User $user)
    {

    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EventType $eventType): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return Auth::user()->role_id==1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return Auth::user()->role_id==1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return Auth::user()->role_id==1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EventType $eventType): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EventType $eventType): bool
    {
        return Auth::user()->role_id==1;
    }
}
