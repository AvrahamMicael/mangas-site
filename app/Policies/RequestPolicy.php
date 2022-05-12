<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function request(User $user)
    {
        return $user->role == Role::IS_SCAN_LEADER;
    }

    public function scanRequests(User $user)
    {
        return in_array($user->role, [Role::IS_SCAN_HELPER, Role::IS_SCAN_LEADER]);
    }

    public function accept(User $user)
    {
        return $user->role == Role::IS_ADMIN;
    }

    public function refuse(User $user)
    {
        return $user->role == Role::IS_ADMIN;
    }

    public function cancel(User $user)
    {
        return $user->role == Role::IS_SCAN_LEADER;
    }

    public function adminRequests(User $user)
    {
        return $user->role == Role::IS_ADMIN;
    }

    public function history(User $user)
    {
        return in_array($user->role, [Role::IS_ADMIN, Role::IS_SCAN_LEADER, Role::IS_SCAN_HELPER]);
    }
}