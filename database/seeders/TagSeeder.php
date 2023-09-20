<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::insert([
            [
                'name' => 'Tecnologia',
            ],
            [
                'name' => 'Electrodomestico'
            ],
            [
                'name' => 'Computación'
            ],
            [
                'name' => 'Ropa'
            ],
            [
                'name' => 'Higiene'
            ],
            [
                'name' => 'Restaurant'
            ],
            [
                'name' => 'Bar'
            ],
        ]);
    }
}
