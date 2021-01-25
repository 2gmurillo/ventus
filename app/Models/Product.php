<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public const STATUSES = [
        'available' => 'available',
        'unavailable' => 'unavailable',
    ];
    public const MINIMUM_STOCK = 15;

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
        return "\${$this->price} USD";
    }

    /**
     * Scope a query to only include order for products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCategory(Builder $query, $category): Builder
    {
        if ($category) {
            return $query->where('category_id', $category);
        }
        return $query;
    }

    /**
     * Scope a query to only include order for products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrder(Builder $query, $order_by): Builder
    {
        switch ($order_by) {
            case 'asc':
                return $query->orderBy('price', 'asc');
            case 'desc':
                return $query->orderBy('price', 'desc');
            case 'old':
                return $query;
            default:
                return $query->latest();
        }
    }

    /**
     * Scope a query to only include search products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSearch(Builder $query, $search): Builder
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%");
        }
        return $query;
    }

    /**
     * Get all of the carts that are assigned this product.
     *
     * @return BelongsToMany
     */
    public function carts(): BelongsToMany
    {
        return $this
            ->belongsToMany(Cart::class)
            ->withPivot('quantity');
    }
}
