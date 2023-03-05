<?php

namespace Database\Factories;

use App\Models\ServantCompletaryData;
use App\Models\Contract;
use App\Models\Workload;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * @method ServantCompletaryData create(mixed $parameters = [])
 * @method ServantCompletaryData make(mixed $parameters = [])
 */
class ServantCompletaryDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServantCompletaryData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'formation'  => $this->faker->title(),
            'observation' => $this->faker->text(),
            'contract_id' => Contract::factory(),
            'workload_id'  => Workload::factory(),
        ];
    }
}
