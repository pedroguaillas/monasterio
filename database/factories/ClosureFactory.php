<?php

namespace Database\Factories;

use App\Models\Closure;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClosureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Closure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => 1,
            'type' => 'diario',
            'date' => $this->faker->date('2021-m-d'),
            'entry' => rand(67, 233),
            'egress' => rand(20, 100),
        ];
    }
}
