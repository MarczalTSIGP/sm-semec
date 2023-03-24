<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;
use App\Models\ServantCompletaryData;

/**
 * @method Movement create(mixed $parameters = [])
 * @method Movement make(mixed $parameters = [])
 */
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
            'period' => $this->faker->randomElement(['morning', 'evening']),
            'occupation' => $this->faker->name(),
            'started_at' => $this->faker->dateTimeBetween('now', '+01 days'),
            'ended_at' => $this->faker->dateTimeBetween('+02 days', '+04 days'),
            'unit_id' => Unit::factory(),
            'servant_completary_data_id' => ServantCompletaryData::factory(),
        ];
    }
}
