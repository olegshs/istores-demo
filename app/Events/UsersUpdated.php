<?php

namespace App\Events;

use App\Models\User;

interface UsersUpdated
{
    public function getUser(): User;
}
