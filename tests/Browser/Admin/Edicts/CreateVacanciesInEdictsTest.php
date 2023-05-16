<?php

namespace Tests\Browser\Admin\Edicts;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Carbon\Carbon;
use App\Models\Edict;
use App\Models\User;
use App\Models\Unit;
use App\Models\RemovalType;
use Illuminate\Support\Str;

class CreateVacanciesInEdictsTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\Unit */
    protected $units;

    public function setUp(): void
    {
        parent::setUp();

        $this->edict = Edict::factory()->state([
            'started_at' => Carbon::yesterday()->toShortDateTime(),
            'ended_at'   => Carbon::tomorrow()->toShortDateTime()])->create();

        $this->units = Unit::factory()->count(3)->create();
        $this->user = User::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)
                    ->visit(route('admin.new.vacancies', $this->edict->id));

            $unit = $this->units->first();

            $browser->selectize('edictUnit_unit_id', $unit->id)
                    ->type('available_vacancies', 10)
                    ->press('Adicionar quantidade de vagas');

            $browser->assertUrlIs(route('admin.edicts'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Vagas cadastradas com sucesso!');
            });
        });
    }

    public function testFailureUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.vacancies', $this->edict->id));

            $browser->press('Adicionar quantidade de vagas');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.edictUnit_unit_id', function ($flash) {
                $flash->assertSee('O campo unidade é obrigatório.');
            });

            $browser->with('div.edictUnit_available_vacancies', function ($flash) {
                $flash->assertSee('O campo quantidade de vagas é obrigatório.');
            });
        });
    }
}
