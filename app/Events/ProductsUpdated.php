<?php

namespace App\Events;

use App\Models\Product;

interface ProductsUpdated
{
    public function getProduct(): Product;
}
