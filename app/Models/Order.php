<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    protected $fillable = [
        'order_number',
        'customer_name',
        'phone',
        'email',
        'address',
        'note',
        'status',
        'subtotal',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'total' => 'integer',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
