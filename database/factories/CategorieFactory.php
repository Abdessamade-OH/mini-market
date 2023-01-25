<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Categorie::class;

    public function definition()
    {
        return [
            //
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'icon_class' => $this->faker->word,
            'created_at' => now()
        ];
    }
}
