<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'user_id' => $this->faker->numberBetween(6,9),
            'price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
