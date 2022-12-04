<?php

namespace Tests\Browser\Admin\ServantCompletaryData;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\ServantCompletaryData;
use App\Models\User;
use App\Models\Contract;
use App\Models\Workload;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\Workload */
    protected $workloads;

    /** @var \App\Models\Contract */
    protected $contract;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->contract = Contract::factory()->create();
        $this->workloads = Workload::factory()->create();
    }*/

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/servants/1/contracts/1/completary-datas/new');

            $this->workloads->first();

            $browser->type('formation', 'Pedagogia');
            $browser->radio('span.custom-control-label', '20');
            $browser->type('observation', 'Teste');

            $browser->press('Criar Cadastro');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Cadastro Complementar adicionado com sucesso');
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/servants/1/contracts/1/completary-datas/new');

            $browser->press('Criar Cadastro');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.servantCompletaryData_formation', function ($flash) {
                $flash->assertSee('O campo formação é obrigatório.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/servants/1/contracts/1/completary-datas/new');

            $backLinkSelector = "#main-card a[href='" .
            route('admin.index.completary_datas', ['servant_id' => $this->contract->servant_id, 'id' =>
                $this->contract->id]) . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.servants') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $fourthBreadcrumbSelector = ".breadcrumb li:nth-child(4)";
            $fifthBreadcrumbSelector = ".breadcrumb li:nth-child(5)";
            $sixthBreadcrumbSelector = ".breadcrumb li:nth-child(6)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Servidores');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Servidor #{$this->contract->servant_id}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, 'Cadastro Complementar');
            $browser->assertSeeIn($fifthBreadcrumbSelector, 'Dados Complementares');
            $browser->assertSeeIn($sixthBreadcrumbSelector, 'Criar Cadastro Complementar');
        });
    }
}
