<?php

namespace Database\Factories;

use App\Models\ServantCompletaryData;
use App\Models\Contract;
use App\Models\Workload;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
            'formation_id'  => Formation::factory(),
            'observation' => $this->faker->text(),
            'contract_id' => Contract::factory(),
            'workload_id'  => Workload::factory(),
        ];
    }
}
