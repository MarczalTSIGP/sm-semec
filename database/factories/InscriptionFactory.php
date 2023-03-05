<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Inscription;
use App\Models\Servant;
use App\Models\Contract;
use App\Models\RemovalType;
use App\Models\Unit;
use App\Models\Edict;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @method Inscription create(mixed $parameters = [])
 */
class InscriptionFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'servant_id' => Servant::factory(),
            'contract_id' => Contract::factory(),
            'removal_type_id' => RemovalType::factory(),
            'edict_id' => Edict::factory(),
            'current_unit_id' => Unit::factory(),
            'reason' => $this->faker->text(),
        ];
    }
}
