<?php

namespace Database\Factories;

use App\Models\VacancyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VacancyResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' =>  $this->faker->text(),
        ];
    }
}
