<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;
use App\Models\Role;
use App\Models\ServantCompletaryData;

class MovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'started_at' => $this->faker->dateTimeBetween('now', '+01 days'),
            'ended_at' => $this->faker->dateTimeBetween('+02 days', '+04 days'),
            'unit_id' => Unit::factory(),
            'role_id' => Role::factory(),
            'servant_completary_data_id' =>  ServantCompletaryData::factory(),
        ];
    }
}
