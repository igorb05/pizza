<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'items',
        'comment',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    public static function booted(): void
    {
        self::creating(function (Order $order) {
            $order->uuid = Str::uuid();
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeByUuid(Builder $query, $uuid): void
    {
        $query->where('uuid', $uuid);
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->where(function ($query) {
            $query->where('status', '!=', 'finalized')
                ->orWhere('updated_at', '>=', now()->subMinutes(30));
        });
    }
}
