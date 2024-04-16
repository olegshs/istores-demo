<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property string $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProductImage extends Model
{
    use HasFactory;
}
