<?php

namespace Tests\Browser\Admin\ServantCompletaryData\Movements;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Movement;
use App\Models\Unit;

class UpdateTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\Unit */
    protected $unit;

    /** @var \App\Models\Movement */
    protected $movement;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->unit = Unit::factory()->create();
        $this->movement = Movement::factory()->create();
    }*/

    public function testFilledFields(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.movement', ['servant_id' =>
                $this->movement->servantCompletaryData->contract->servant_id,
                'contract_id' => $this->movement->servantCompletaryData->contract_id,
                'completaryData_id' => $this->movement->servantCompletaryData->id,
                'id' => $this->movement->id]));

            $browser->assertInputValue('occupation', $this->movement->occupation)
                    ->assertRadioSelected('period', $this->movement->period)
                    ->assertSelected('unit_id', $this->movement->unit_id);
        });
    }

    /*public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
                $browser->loginAs($this->user)->visit(route('admin.edit.movement', ['servant_id' =>
                    $this->movement->servantCompletaryData->contract->servant_id,
                'contract_id' => $this->movement->servantCompletaryData->contract_id,
                'completaryData_id' => $this->movement->servantCompletaryData->id, 'id' => $this->movement->id]));

                $newData = Movement::factory()->create([
                    'started_at' => '28/01/2021 15:18',
                    'ended_at' => '29/07/2021 15:18'
                ]);

                $browser->type('occupation', $newData->occupation)
                ->radio('span.custom-control-label', 'evening')
                ->type('started_at', $newData->started_at->toShortDateTime())
                ->type('ended_at', $newData->ended_at->toShortDateTime())
                ->press('Atualizar Movimentação');

                $browser->assertUrlIs(route('admin.index.completary_datas', ['servant_id' =>
                    $this->movement->servantCompletaryData->contract->servant_id,
                'id' => $this->movement->servantCompletaryData->contract_id]));

                $browser->with('div.alert', function ($flash) {
                    $flash->assertSee('Movimentação atualizada com sucesso');
                });

                $browser->scrollIntoView('.table.table tbody');

                $browser->with('table.table tbody', function ($table) use ($newData) {
                    $table->assertSee($newData->occupation);
                    $table->assertDontSee($this->movement->occupation);
                });
        });
    }*/

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
                $browser->loginAs($this->user)->visit(route('admin.edit.movement', ['servant_id' =>
                    $this->movement->servantCompletaryData->contract->servant_id,
                    'contract_id' => $this->movement->servantCompletaryData->contract_id,
                    'completaryData_id' => $this->movement->servantCompletaryData->id,
                    'id' => $this->movement->id]));

                $browser->type('occupation', '')
                ->type('started_at', '')
                ->press('Atualizar Movimentação');

                $browser->with('div.alert', function ($flash) {
                    $flash->assertSee('Existem dados incorretos! Por favor verifique!');
                });

                $browser->with('div.movement_occupation', function ($flash) {
                    $flash->assertSee('O campo função é obrigatório.');
                });

                $browser->with('div.movement_started_at', function ($flash) {
                    $flash->assertSee('O campo Início é obrigatório.');
                });
        });
    }

    /*public function testAssertLinksPresent(): void
    {
        $this->movement = Movement::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.movement', ['servant_id' =>
                $this->movement->servantCompletaryData->contract->servant_id,
            'contract_id' => $this->movement->servantCompletaryData->contract_id,
            'completaryData_id' => $this->movement->servantCompletaryData->id,
            'id' => $this->movement->id]));

            $backLinkSelector = "#main-card a[href='" . route('admin.index.completary_datas', ['servant_id' =>
                $this->movement->servantCompletaryData->contract->servant_id, 'id' =>
                $this->movement->servantCompletaryData->contract_id]) . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.servants') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $fourthBreadcrumbSelector = ".breadcrumb li:nth-child(4)";
            $fifthBreadcrumbSelector = ".breadcrumb li:nth-child(5)";
            $sixthBreadcrumbSelector = ".breadcrumb li:nth-child(6)";

            $route = $this->movement->servantCompletaryData->contract->servant_id;

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Servidores')
            ->assertSeeIn($thirdBreadcrumbSelector, "Servidor #{$route}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, "Cadastro Complementar");
            $browser->assertSeeIn($fifthBreadcrumbSelector, "Dados Complementares");
            $browser->assertSeeIn($sixthBreadcrumbSelector, "Editar Movimentação #{$this->movement->id}");
        });
    }*/
}
