<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User,Store,UserStore};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserStoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $exists = true;
        
        $user_id = null;
        $store_id = null;  
        
        while ($exists) {
    
            $user_id = User::inRandomOrder()->first()->id;

            $store_id = Store::inRandomOrder()->first()->id;
            
            $exists = UserStore::where('user_id',$user_id)->where('store_id',$store_id)->exists();
        }

        return [
            'user_id' => $user_id,
            'store_id' =>  $store_id,
            'created_at' => null,
            'updated_at' => null
        ];
    }
}
