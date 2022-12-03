<?php

/*namespace Tests\Browser\Edicts;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Pdf;

class IndexTest extends DuskTestCase
{
    public function testIndexList(): void
    {
        $pdfs = Pdf::factory()->create();
        $this->browse(function ($browser) use ($pdfs) {
                $browser->visit('/edicts')
                ->press(now()->year)
                ->press($pdfs->edict->title)
                ->assertSeeLink($pdfs->name);
        });
    }
}*/
