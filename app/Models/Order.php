<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    public const APPROVED = 'Aprobado';
    public const REJECTED = 'Rechazado';
    public const PENDING = 'Pendiente';
    public const IN_PROCESS = 'En proceso';
    public const EXPIRATION = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'status',
        'process_url',
        'quantity',
        'customer_id',
        'payment_gateway_id',
    ];

    /**
     * Get the user that owns the order.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the products for the order.
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
     * Get the payment gateway record associated with the order.
     *
     * @return BelongsTo
     */
    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    /**
     * Get the total price of the products in the order.
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        return $this->products->pluck('total')->sum();
    }
}
