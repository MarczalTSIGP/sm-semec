<?php

namespace Tests\Browser\Servants\Inscriptions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Edict;
use App\Models\Servant;
use App\Models\Inscription;

class ShowTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    /** @var \App\Models\Inscription */
    protected $inscription;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory('servant')->create();
        $this->inscription = Inscription::factory()->create(['servant_id' => 1]);
    }*/

    public function testShow(): void
    {
        $this->browse(function ($browser) {
            $route = route('servant.show.inscription', $this->inscription->id);
            $browser->loginAs($this->servant, 'servant')->visit($route);

            $browser->with('#main-card .card-body', function ($body) {
                $body->assertSee($this->inscription->servant->name);
                $body->assertSee($this->inscription->contract->registration);
                $body->assertSee($this->inscription->currentUnit->name);
                $body->assertSee($this->inscription->removalType->name);
                $body->assertSee($this->inscription->reason);
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->browse(function ($browser) {
            $route = route('servant.show.inscription', $this->inscription->id);
            $browser->loginAs($this->servant, 'servant')->visit($route);

            $backLinkSelector = "#main-card a[href='" . route('servant.inscriptions') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('servant.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('servant.inscriptions') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Minhas Inscrições');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Inscrição #{$this->inscription->id}");
        });
    }
}
