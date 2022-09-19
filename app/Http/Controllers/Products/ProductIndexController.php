<?php

namespace App\Http\Controllers\Products;

use App\Domain\Product\Attribute;
use App\Domain\Product\Product;
use App\Http\Requests\Product\SearchRequest;

class ProductIndexController
{
    public function __invoke(SearchRequest $request)
    {
        # Load Attributes
        $attributes = Attribute::orderBy('value')->get()
            ->map(fn($attribute) => [
                'title' => $attribute->value,
                'value' => $attribute->id,
                'type' => $attribute->type->value,
            ])
            ->groupBy('type')
            ->toArray();

        # Load Products
        $products = Product::useFilter([
            'cities' => $request->get('cities'),
            'category' => $request->get('category'),
        ])->paginate();

        return view('products.index', compact('attributes', 'products'));
    }
}
