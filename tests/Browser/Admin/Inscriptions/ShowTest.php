<?php

namespace Tests\Browser\Admin\Inscriptions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Inscription;
use App\Models\User;

class ShowTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;
    /** @var \App\Models\Inscription */
    protected $inscription;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->inscription = Inscription::factory()->create(['servant_id' => 1]);
    }*/

    public function testShow(): void
    {
        $this->browse(function ($browser) {
            $route = ['edict_id' => $this->inscription->edict_id, 'id' => $this->inscription->id];
            $browser->loginAs($this->user)->visit(route('admin.show.inscription', $route));

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
            $route = ['edict_id' => $this->inscription->edict_id, 'id' => $this->inscription->id];
            $browser->loginAs($this->user)->visit(route('admin.show.inscription', $route));

            $backLinkSelector = "#main-card a[href='" . route('admin.inscriptions', $this->inscription->id) . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.edicts') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $fourthBreadcrumbSelector = ".breadcrumb li:nth-child(4)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Inscrições no Edital #{$this->inscription->edict->id}");
            $browser->assertSeeIn($fourthBreadcrumbSelector, "Inscrição #{$this->inscription->id}");
        });
    }
}
