<?php

namespace App\Http\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthHelper
{
    public static function getStoreId(): ?int
    {
        $storeId = Session::get('store_id');
        if ($storeId) {
            return $storeId;
        }

        return Auth::id();
    }

    /**
     * @throws \Exception
     */
    public static function setStoreId(int $storeId): void
    {
        $user = Auth::user();
        if (!($user instanceof User) || !$user->isAdmin()) {
            throw new \Exception("Current user is unauthorized to change store_id.");
        }

        Session::put('store_id', $storeId);
    }
}
