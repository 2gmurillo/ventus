<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can do all actions.
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view any product.
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can create a product.
     *
     * @param User $user
     * @return void
     */
    public function create(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can update a product.
     *
     * @param User $user
     * @param Product $product
     * @return void
     */
    public function update(User $user, Product $product): void
    {
        //
    }

    /**
     * Determine whether the user can delete a product.
     *
     * @param User $user
     * @param Product $product
     * @return void
     */
    public function delete(User $user, Product $product): void
    {
        //
    }
}
