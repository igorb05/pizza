<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'config',
        'tag',
        'image',
        'price',
        'old_price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function booted(): void
    {
        self::creating(function (Pizza $pizza) {
            $pizza->slug = Str::slug($pizza->name);
        });
    }
}
