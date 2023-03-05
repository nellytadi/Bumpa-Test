<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
