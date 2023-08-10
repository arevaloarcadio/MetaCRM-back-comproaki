<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Tag,Store};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreTag>
 */
class StoreTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => Tag::inRandomOrder()->first()->id,
            'store_id' => Store::inRandomOrder()->first()->id,
            'created_at' => null,
            'updated_at' => null
        ];
    }
}
