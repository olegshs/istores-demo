<?php

namespace App\Models;

enum OrderStatus: string
{
    case New = 'new';
    case Paid = 'paid';
    case Processing = 'processing';
    case Completed = 'completed';
}
