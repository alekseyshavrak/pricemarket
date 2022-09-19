<?php

namespace App\Domain\Product;

use App\Domain\Product\Enums\AttributeType;
use Database\Factories\AttributeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => AttributeType::class,
    ];

    protected static function newFactory(): AttributeFactory
    {
        return new AttributeFactory();
    }

    public function scopeCity(Builder $query): Builder
    {
        return $query->where('type', AttributeType::city());
    }

    public function scopeCategory(Builder $query): Builder
    {
        return $query->where('type', AttributeType::category());
    }
}
