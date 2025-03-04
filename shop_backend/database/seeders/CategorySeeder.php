<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Compact Cars',
            'description' => 'Perfect for small cars like hatchbacks and sedans. A quick and efficient wash that focuses on compact vehicle cleaning.',
        ]);

        Category::create([
            'name' => 'SUVs & Crossovers',
            'description' => 'Designed for sport utility vehicles and crossovers, providing extra attention to larger body surfaces and wheels.',
        ]);

        Category::create([
            'name' => 'Luxury Cars',
            'description' => 'Tailored for high-end vehicles, offering premium care with specialized products to preserve the exterior finish and delicate surfaces.',
        ]);

        Category::create([
            'name' => 'Vans & Minivans',
            'description' => 'Ideal for larger family or work vehicles, ensuring thorough cleaning of both the interior and exterior, including hard-to-reach spots.',
        ]);

        Category::create([
            'name' => 'Trucks & Pickups',
            'description' => 'For larger vehicles with tougher exteriors, focusing on cleaning heavy-duty surfaces, wheels, and undercarriages.',
        ]);

        Category::create([
            'name' => 'Motorcycles',
            'description' => 'A dedicated service for two-wheeled vehicles, with specialized care for smaller, intricate parts.',
        ]);
    }
}
