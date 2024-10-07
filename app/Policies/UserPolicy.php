<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function manageUsers(User $user)
    {
        return $user->role === 1;
    }
}
