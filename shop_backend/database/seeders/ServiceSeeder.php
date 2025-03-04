<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Inserting services data for compact cars
        DB::table('services')->insert([
            [
                'name' => 'Engine Oil Change',
                'description' => 'Change the engine oil to ensure optimal engine performance and prevent wear and tear.',
                'price' => 50,
                'category_id' => 1, // Assuming 3 is the ID for Compact Cars category
            ],
            [
                'name' => 'Tire Rotation',
                'description' => 'Rotate the tires to ensure even wear and extend the lifespan of the tires.',
                'price' => 30,
                'category_id' => 1, // Assuming 3 is the ID for Compact Cars category
            ],
            [
                'name' => 'Brake Inspection',
                'description' => 'Inspect the brake system for wear and replace brake pads if necessary for safe driving.',
                'price' => 40,
                'category_id' => 1, // Assuming 3 is the ID for Compact Cars category
            ],
            [
                'name' => 'Air Filter Replacement',
                'description' => 'Replace the air filter to maintain good engine performance and fuel efficiency.',
                'price' => 20,
                'category_id' => 1, // Assuming 3 is the ID for Compact Cars category
            ],
            [
                'name' => 'Battery Check & Replacement',
                'description' => 'Check the car battery’s health and replace it if it’s weak or old.',
                'price' => 60,
                'category_id' => 1, // Assuming 3 is the ID for Compact Cars category
            ],
        ]);
    }
}
