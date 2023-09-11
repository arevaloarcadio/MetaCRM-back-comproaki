<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Store,StoreTag,User,Category,UserStore};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $store_id = Store::whereRaw('id IN(SELECT store_id FROM user_stores)')
            ->inRandomOrder()
            ->first()
            ->id;

        $user_id = UserStore::where('store_id',$store_id)
            ->first()
            ->user_id;

        $category_id = Category::where('store_id',$store_id)
            ->first()
            ->id;

        return [
            'name' => fake()->word(),
            'image' => fake()->imageUrl(640, 480),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 0, 1000),
            'store_id' => $store_id,
            'user_id' => $user_id,
            'category_id' => $category_id,
        ];
    }
}
