<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public const STATUSES = [
        'available' => 'available',
        'unavailable' => 'unavailable',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo',
        'price',
        'category_id',
        'stock',
        'status',
    ];

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the formatted price of the product.
     *
     * @return string
     */
    protected function getFormattedPriceAttribute(): string
    {
        return $this->price;
    }
}
