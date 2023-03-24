<?php

namespace Tests\Browser\Admin\Pdfs;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Edict;
use App\Models\User;
use App\Models\Pdf;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\Edict */
    protected $edict;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->edict = Edict::factory()->create();
        $this->user = User::factory()->create();
    }
    /**
     * @group spec
     */
    public function testIndexList(): void
    {
        $pdfs = Pdf::factory()->count(2)->create(['edict_id' => $this->edict->id]);

        $this->browse(function ($browser) use ($pdfs) {
            $browser->loginAs($this->user)->visit("/admin/edicts/{$this->edict->id}/pdfs");

            $browser->with("table.table tbody", function ($row) use ($pdfs) {
                $pos = 0;
                foreach ($pdfs as $pdf) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";
                    $route = route('admin.show.pdf', ['edict_id' => $this->edict->id, 'id' => $pdf->id]);

                    $showSelector = $baseSelector . "a[href='" . $route . "']";
                    $row->assertSeeIn($showSelector, $pdf->name);
                    $row->assertSeeIn($baseSelector, $pdf->edict->title);
                    $row->assertSeeIn($baseSelector, $pdf->created_at->toShortDateTime());
                    $row->assertSeeIn($baseSelector, $pdf->updated_at->toShortDateTime());

                    $deleteSelector = $baseSelector . "form[action='" . route('admin.destroy.pdf', $pdf->id) . "']";
                    $row->assertPresent($deleteSelector);
                }
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        Pdf::factory()->create(['edict_id' => $this->edict->id]);

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.index.pdf', $this->edict->id));

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";
            $thirdBreadcrumSelector = ".breadcrumb li:nth-child(3)";

            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Editais');
            $browser->assertSeeIn($thirdBreadcrumSelector, 'Novo PDF');
        });
    }
}
