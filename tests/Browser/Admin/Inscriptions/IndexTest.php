<?php

namespace Tests\Browser\Admin\Inscriptions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Inscription;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }*/

    /*public function testIndexList(): void
    {
        $inscription = Inscription::factory()->create();

        $this->browse(function ($browser) use ($inscription) {
            $browser->loginAs($this->user)->visit('/admin/edicts/1/inscriptions');

            $browser->with("table.table tbody", function ($row) use ($inscription) {
                $pos = 0;

                $pos += 1;
                $baseSelector = "tr:nth-child({$pos}) ";
                $route = ['edict_id' => $inscription->edict->id, 'id' => $inscription->id];
                $showSelector = $baseSelector . "a[href='" . route('admin.show.inscription', $route) . "']";
                $row->assertSeeIn($showSelector, $inscription->servant->name);
                $row->assertSeeIn($baseSelector, $inscription->contract->registration);
                $row->assertSeeIn($baseSelector, $inscription->removalType->name);
                $row->assertSeeIn($baseSelector, $inscription->created_at->toShortDateTime());
            });
        });
    }*/

    /*public function testAssertLinksPresent(): void
    {
        $inscription = Inscription::factory()->create();

        $this->browse(function ($browser) use ($inscription) {
            $browser->loginAs($this->user)->visit('/admin/edicts/1/inscriptions');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.edicts') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Inscrições no Edital #{$inscription->edict->id}");
        });
    }*/
}
