<?php

namespace App\Domain\Product;

use App\Domain\Inventory\Projections\Inventory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'manages_inventory' => 'boolean',
    ];

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItemPrice(): Price
    {
        return new Price($this->item_price, $this->vat_percentage);
    }

    public function managesInventory(): bool
    {
        return $this->manages_inventory ?? false;
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function hasAvailableInventory(int $requestedAmount): bool
    {
        return $this->inventory->amount >= $requestedAmount;
    }

    public function scopeUseFilter(Builder $query, array $attributes): Builder
    {
        # Filter by City
        $cities = (array) data_get($attributes, 'cities', []);

        if (count($cities) > 0) {
            $cities = collect($cities)->map(fn($city) => (int) $city)->toArray();

            $query->whereHas('attributes',
                fn($query) => $query->whereIn('id', $cities)
            );
        }

        # Filter by Category
        $category = (int) data_get($attributes, 'category');

        if ($category) {
            $query->whereHas('attributes',
                fn($query) => $query->where('id', $category)
            );
        }

        return $query;
    }
}
