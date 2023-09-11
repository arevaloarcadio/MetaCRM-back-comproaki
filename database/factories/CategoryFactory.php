<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Store,StoreTag,User,UserStore};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        //ClassName::factory()->count(3)->create()
        
        $store_id = Store::whereRaw('id IN(SELECT store_id FROM user_stores)')->inRandomOrder()->first()->id;
       
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(3),
            'image' => fake()->imageUrl(640, 480),
            'store_id' => $store_id,
        ];
    }
}
