<?php

namespace App\Policies;

use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class OrderProductPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, OrderProduct $orderProduct): bool
    {
        return $orderProduct->order->session_id == Session::getId();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, OrderProduct $orderProduct): bool
    {
        return $orderProduct->order->session_id == Session::getId();
    }
}
