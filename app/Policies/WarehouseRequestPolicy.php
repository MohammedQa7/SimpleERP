<?php

namespace App\Policies;

use App\Enums\WarehouseStatus;
use App\Models\User;
use App\Models\WarehouseRequests;
use Illuminate\Auth\Access\Response;

class WarehouseRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WarehouseRequests $warehouseRequests): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WarehouseRequests $stock_request): bool
    {
        return $stock_request->status->value == WarehouseStatus::PENDING->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WarehouseRequests $warehouseRequests): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WarehouseRequests $warehouseRequests): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WarehouseRequests $warehouseRequests): bool
    {
        return false;
    }
}