<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'min_quantity',
        'unit_price',
        'unit_type',
        'active',
        'expiry_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'min_quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'active' => 'boolean',
        'expiry_date' => 'date'
    ];

    /**
     * Check if stock is low (below minimum quantity)
     *
     * @return bool
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    /**
     * Update stock quantity
     *
     * @param int $amount
     * @param string $type ('add' or 'subtract')
     * @return bool
     */
    public function updateQuantity(int $amount, string $type = 'add'): bool
    {
        if ($type === 'add') {
            $this->quantity += $amount;
        } else {
            if ($this->quantity - $amount < 0) {
                return false;
            }
            $this->quantity -= $amount;
        }

        return $this->save();
    }

    /**
     * Get the total value of current stock
     *
     * @return float
     */
    public function getTotalValue(): float
    {
        return $this->quantity * $this->unit_price;
    }
}