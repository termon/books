<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{

    /**
     * Determine whether the user is an admin and authorise all actions
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->role == Role::ADMIN ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == Role::GUEST;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role == Role::ADMIN || $user->role == Role::AUTHOR;
    }
}
