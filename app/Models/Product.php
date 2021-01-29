<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

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
    public function scopeCategorySelect(Builder $query, $category): Builder
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
    public function scopeOrderBySelect(Builder $query, $order_by): Builder
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

    /**
     * Get the total price of the quantity of one product in the cart or the order.
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        return $this->pivot->quantity * $this->price;
    }

    /**
     * Get the total price of the quantity of one product in the cart or the order.
     *
     * @return string
     */
    public function getFormattedTotalAttribute(): string
    {
        $total = $this->pivot->quantity * $this->price;
        return "\${$total} USD";
    }

    /**
     * Scope a query to only include available products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUSES['available']);
    }

    /**
     * Scope a query to ask if product is available.
     *
     * @return bool
     */
    public function isNotAvailable(): bool
    {
        return $this->status === self::STATUSES['unavailable'];
    }

    public static function getCachedAdminProducts(): object
    {
        $key = 'admin.products.index.page.' . request('page', 1);
        return Cache::tags('admin.products')
            ->rememberForever($key, function () {
                return Product::with('category')
                    ->latest()
                    ->paginate(8);
            });
    }

    public static function flushCache(): void
    {
        Cache::tags('admin.products')->flush();
    }
}
