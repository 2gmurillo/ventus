<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];

    /**
     * Get the user that owns the cart.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the products for the cart.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    /**
     * Get the total price of the products in the cart.
     *
     * @return float
     */
    protected function getTotalAttribute(): float
    {
        return $this->products->pluck('total')->sum();
    }

    /**
     * Get formatted total price of the products in the cart.
     *
     * @return string
     */
    protected function getFormattedTotalAttribute(): string
    {
        return "\${$this->products->pluck('total')->sum()} USD";
    }
}
