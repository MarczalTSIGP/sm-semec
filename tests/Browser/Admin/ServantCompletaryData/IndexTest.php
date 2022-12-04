<?php

namespace Tests\Browser\Admin\ServantCompletaryData;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\ServantCompletaryData;
use App\Models\Movement;
use App\Models\Servant;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\ServantCompletaryData */
    protected $completaryData;

    /** @var \App\Models\Movement */
    protected $movement;

    /** @var string */
    protected $url;



    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->completaryData = ServantCompletaryData::factory()->create();
        $this->movement = Movement::factory()->create(['servant_completary_data_id' => $this->completaryData->id]);
        $this->url = route('admin.index.completary_datas', [
                             'servant_id'  => $this->completaryData->contract->servant_id,
                             'id' => $this->completaryData->contract_id
                             ]);
    }*/

    public function testIndexList(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit($this->url);

            $browser->with('#main-card fieldset:nth-child(1)', function ($div) {
                $div->assertSee('Dados do Contrato');
                $div->assertSee($this->completaryData->contract->registration);
                $div->assertSee($this->completaryData->contract->role);
                $div->assertSee($this->completaryData->contract->secretary);
                $div->assertSee($this->completaryData->contract->place);
                $div->assertSee($this->completaryData->contract->link);
                $div->assertSee($this->completaryData->contract->admission_at->toShortDate());
            });

            $browser->scrollIntoView('#main-card fieldset:nth-child(2)');
            $browser->with('#main-card fieldset:nth-child(2)', function ($div) {
                $div->assertSee('Dados Adicionais');
                $div->assertSee($this->completaryData->formation);
                $div->assertSee($this->completaryData->workload->hours);
                $div->assertSee($this->completaryData->observation);
            });

            $browser->assertSee('Movimentações');
            $browser->scrollIntoView('.table');
            $browser->with('.table', function ($body) {
                $body->assertSee($this->movement->servantCompletaryData->contract->registration);
                $body->assertSee($this->movement->occupation);
                $body->assertSee(__($this->movement->period));
                $body->assertSee($this->movement->unit->name);
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit($this->url);

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.servants') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $fourthBreadcrumbSelector = ".breadcrumb li:nth-child(4)";
            $fifthBreadcrumbSelector = ".breadcrumb li:nth-child(5)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Servidores');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Servidor #{$this->completaryData->contract->servant_id}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, 'Cadastro Complementar');
            $browser->assertSeeIn($fifthBreadcrumbSelector, 'Dados Complementares');
        });
    }
}
