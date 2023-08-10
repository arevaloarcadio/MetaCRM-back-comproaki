<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Store,StoreTag,User,UserStore};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'state' => $this->faker->state,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'image' => $this->faker->imageUrl(640, 480),
        ];
    }

    public function configure()
    {
        

        return $this->afterCreating(function (Store $store) {
            $store_tag = StoreTag::factory()->count(3)->create()->toArray();
            //StoreTag::insert($store_tag);

            $user_store = UserStore::factory()->count(1)->create()->toArray();
            //UserStore::insert($user_store);
            
        });
    }
}
