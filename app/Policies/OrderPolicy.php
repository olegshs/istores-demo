<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Order $order): bool
    {
        return $this->hasAccessToOrder($user, $order);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Order $order): bool
    {
        return $this->hasAccessToOrder($user, $order);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Order $order): bool
    {
        return $this->hasAccessToOrder($user, $order);
    }

    /**
     * @param User|null $user
     * @param Order $order
     * @return bool
     */
    private function hasAccessToOrder(?User $user, Order $order): bool
    {
        if ($order->session_id == Session::getId()) {
            return true;
        }
        if ($user) {
            if ($order->store_id == $user->id) {
                return true;
            }
            if ($user->isAdmin()) {
                return true;
            }
        }
        return false;
    }
}
