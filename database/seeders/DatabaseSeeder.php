<?php

namespace Database\Seeders;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Coupon\Coupon;
use App\Domain\Customer\Customer;
use App\Domain\Product\Attribute;
use App\Domain\Product\Enums\AttributeType;
use App\Domain\Product\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        # Create Attribute
        $attributeCities = Attribute::factory(30)->create([
            'type' => AttributeType::city(),
        ]);

        $attributeCategories = Attribute::factory(100)->create([
            'type' => AttributeType::category(),
        ]);

        # Create Products
        $products = Product::factory(50000)->create();

        $products->each(function ($product) use ($attributeCities, $attributeCategories) {
            # Attach City
            $product->attributes()->attach(
                $attributeCities->random(rand(5, 10))
            );

            # Attach Category
            $product->attributes()->attach(
                $attributeCategories->random(rand(5, 100))
            );
        });

        Coupon::factory()->create();

        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'email' => 'admin@shop.com',
            'name' => 'Admin',
        ]);

        $customer = Customer::create([
            'name' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id,
            'street' => 'Street',
            'number' => '101',
            'postal' => '2000',
            'city' => 'City',
            'country' => 'Belgium',
        ]);

        $cart = (new InitializeCart)($customer);

        (new AddCartItem)($cart, $products->random(1)[0], 1);
        (new AddCartItem)($cart, $products->random(1)[0], 1);
        (new AddCartItem)($cart, $products->random(1)[0], 1);
    }
}
