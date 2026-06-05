<?php

namespace App\Policies;

use App\Models\CategoryAKL;
use App\Models\User;

class CategoryPolicyAKL
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }

    public function view(User $user, CategoryAKL $category)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }

    public function update(User $user, CategoryAKL $category)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }

    public function delete(User $user, CategoryAKL $category)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }
}

