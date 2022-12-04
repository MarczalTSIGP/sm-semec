<?php

namespace Tests\Browser\Servants\Inscriptions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Edict;
use App\Models\Servant;
use App\Models\Inscription;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory('servant')->create();
    }*/

    /*public function testIndexList(): void
    {
        $inscription = Inscription::factory()->create(['servant_id' => 1]);

        $this->browse(function ($browser) use ($inscription) {
            $browser->loginAs($this->servant, 'servant')->visit('/servant/inscriptions');

            $browser->with("table.table tbody", function ($row) use ($inscription) {
                $pos = 0;

                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";
                    $route = route('servant.show.inscription', $inscription->id);

                    $showSelector = $baseSelector . "a[href='" . $route . "']";
                    $row->assertSeeIn($showSelector, $inscription->edict->title);
                    $row->assertSeeIn($baseSelector, $inscription->contract->registration);
            });
        });
    }*/

    public function testAssertLinksPresent(): void
    {
        Inscription::factory()->create();
        $this->browse(function ($browser) {
            $browser->loginAs($this->servant, 'servant')->visit(route('servant.inscriptions'));

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('servant.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Minhas Inscrições');
        });
    }
}
