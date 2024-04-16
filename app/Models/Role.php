<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property RoleName $name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Role extends Model
{
    use HasFactory;
}
