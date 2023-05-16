<?php

namespace Tests\Unit\Edicts;

use App\Models\Edict;
use App\Models\Unit;
use App\Models\EdictUnit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateVacanciesInEdictsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateVacancieInEdicts(): void
    {
        $edict =  Edict::factory()->create();

        $unit =  Unit::factory()->create();

        $requestData = [
            'edict_id' => $edict->id,
            'unit_id' => $unit->id,
            'available_vacancies' => 10,
        ];

        EdictUnit::create($requestData);

        $results = [
            'edict_id' => $requestData['edict_id'],
            'unit_id' => $requestData['unit_id'],
            'available_vacancies' => $requestData['available_vacancies'],
        ];
        $this->assertDatabaseHas('edict_units', $results);
    }
}
