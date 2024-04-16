<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class OrderPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Order $order): bool
    {
        return $order->session_id == Session::getId();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Order $order): bool
    {
        return $order->session_id == Session::getId();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Order $order): bool
    {
        return $order->session_id == Session::getId();
    }
}
