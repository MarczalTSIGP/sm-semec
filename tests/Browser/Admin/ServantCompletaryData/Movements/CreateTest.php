<?php

namespace Tests\Browser\Admin\ServantCompletaryData\Movements;

use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Unit;
use App\Models\Movement;
use App\Models\ServantCompletaryData;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\Unit */
    protected $units;

    /** @var \App\Models\ServantCompletaryData */
    protected $completaryData;

    /** @var \App\Models\Movement */
    protected $movement;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->units = Unit::factory()->create();
        $this->completaryData = ServantCompletaryData::factory()->create();
        $this->movement = Movement::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.movement', ['servant_id' =>
            $this->completaryData->contract->servant_id, 'contract_id' =>
            $this->completaryData->contract_id, 'id' => $this->completaryData->id]));

            $unit = $this->units->first();

            $browser->type('occupation', 'Teste')
                ->radio('span.custom-control-label', 'morning')
                ->selectize('movement_unit_id', $unit->id)
                ->type('started_at', '28/07/2020 15:18')
                ->press('Criar Movimentação');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Movimentação adicionada com sucesso');
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/servants/1/contracts/1/completary-datas/1/movement/new');

            $browser->press('Criar Movimentação');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.movement_occupation', function ($flash) {
                $flash->assertSee('O campo função é obrigatório.');
            });

            $browser->with('div.movement_unit_id', function ($flash) {
                $flash->assertSee('O campo unidade é obrigatório.');
            });

            $browser->with('div.movement_started_at', function ($flash) {
                $flash->assertSee('O campo Início é obrigatório.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->movement = Movement::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.movement', [
                'servant_id' =>
                $this->movement->servantCompletaryData->contract->servant_id,
                'contract_id' => $this->movement->servantCompletaryData->contract_id, 'id' =>
                $this->movement->servantCompletaryData->id
            ]));

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
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Servidores');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Servidor #{$route}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, "Cadastro Complementar");
            $browser->assertSeeIn($fifthBreadcrumbSelector, "Dados Complementares");
            $browser->assertSeeIn($sixthBreadcrumbSelector, "Nova Movimentação");
        });
    }
}
