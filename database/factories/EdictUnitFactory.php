<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\EdictUnit;
use App\Models\Edict;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class EdictUnitFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = EdictUnit::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'edict_id'            => Edict::factory(),
            'unit_id'             => Unit::factory(),
            'available_vacancies' => $this->faker->numberBetween(1, 10),
            'type_of_vacancy'     => 'REGISTERED',
        ];
    }
}
