<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use http\Env\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    public function bookEvent(Request $request,User $user, Event $event){
        $event= $user->events()->where('id', $event->id)->first();
        if($event){
            return false;
        }
        return true;
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
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return Auth::user()->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return Auth::user()->role_id==1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

}
