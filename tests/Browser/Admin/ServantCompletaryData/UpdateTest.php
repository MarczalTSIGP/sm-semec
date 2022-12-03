<?php

namespace Tests\Browser\Admin\ServantCompletaryData;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\ServantCompletaryData;
use App\Models\User;
use App\Models\Contract;
use App\Models\Workload;

class UpdateTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\ServantCompletaryData */
    protected $completaryData;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->completaryData = ServantCompletaryData::factory()->create();
    }*/

    /*{
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('admin/servants/1/contracts/1/completary-datas/1/edit');

            $browser->assertInputValue('formation', $this->completaryData->formation)
            ->assertRadioSelected('workload_id', $this->completaryData->workload_id)
            ->assertInputValue('observation', $this->completaryData->observation);
        });
    }*/

    public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('admin/servants/1/contracts/1/completary-datas/1/edit');
            ServantCompletaryData::factory()->create();

            $browser->type('formation', 'teste')
            ->press('Atualizar Cadastro');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Cadastro Complementar atualizado com sucesso');
            });
        });
    }

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('admin/servants/1/contracts/1/completary-datas/1/edit');

            $browser->type('formation', '')
            ->press('Atualizar Cadastro');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.servantCompletaryData_formation', function ($flash) {
                $flash->assertSee('O campo formação é obrigatório.');
            });
        });
    }

    /*public function testAssertLinksPresent(): void
    {
        $this->completaryData = ServantCompletaryData::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.completary_data', ['servant_id' =>
               $this->completaryData->contract->servant_id, 'contract_id' =>
               $this->completaryData->contract_id, 'id' => $this->completaryData->id]));

            $backLinkSelector = "#main-card a[href='" .
            route('admin.index.completary_datas', ['servant_id' => $this->completaryData->contract->servant_id, 'id' =>
                $this->completaryData->contract_id]) . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.servants') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $fourthBreadcrumbSelector = ".breadcrumb li:nth-child(4)";
            $fifthBreadcrumbSelector = ".breadcrumb li:nth-child(5)";
            $sixthBreadcrumbSelector = ".breadcrumb li:nth-child(6)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Servidores');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Servidor #{$this->completaryData->contract->servant_id}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, 'Cadastro Complementar');
            $browser->assertSeeIn($fifthBreadcrumbSelector, 'Dados Complementares')
            ->assertSeeIn($sixthBreadcrumbSelector, "Editar Cadastro Complementar #{$this->completaryData->id}");
        });
    }*/
}
