<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class TenantPostPolicy
{
  
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return  $user->role === 'tenant'  && $user->is_approved === true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
       return  $user->tenant_id === $post->tenant_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return  $user->tenant_id === $post->tenant_id;
    }


}
