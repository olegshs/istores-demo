<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $store_id
 * @property string $session_id
 * @property OrderStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property OrderDetails $details
 * @property Product[] $products
 */
class Order extends Model
{
    use HasFactory;

    public function details(): HasOne
    {
        return $this->hasOne(OrderDetails::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function toArray(): array
    {
        $arr = parent::toArray();

        if (!isset($arr['details'])) {
            $arr['details'] = (object)[];
        }

        if (!isset($arr['products'])) {
            $arr['products'] = [];
        }

        return $arr;
    }
}
