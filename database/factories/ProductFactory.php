<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'prix' => $this->faker->randomNumber(2),
            'categorie_id' => Categorie::factory(),
            'image_path' => $this->faker->words(3,true),
            'stock' => $this->faker->randomNumber(2),
            'created_at' => now()
        ];
    }
}
