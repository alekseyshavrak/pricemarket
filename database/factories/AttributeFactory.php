<?php

namespace Database\Factories;

use App\Domain\Product\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->text(16),
        ];
    }
}
