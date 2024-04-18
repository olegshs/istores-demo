<?php

namespace App\Events;

use App\Models\Category;

interface CategoriesUpdated
{
    public function getCategory(): Category;
}
