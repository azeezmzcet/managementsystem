<?php

namespace Database\Factories;

use App\Models\studentlists;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\studentlists>
 */
class studentlistsFactory extends Factory
{

    protected $model = studentlists::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registerno'=>$this->faker->unique()->numerify('######'),
            'name'=>$this->faker->name(),
            'city'=>$this->faker->city(),
            'course'=>$this->faker->randomElement(['BBA','B.sc','B.com','B.tech','MBA']),
        ];
    }
}
