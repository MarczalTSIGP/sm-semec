<?php

namespace Tests\Browser\Edicts;

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
                ->waitFor("@btnShowEdict-{$pdfs->edict->id}")
                ->click("@btnShowEdict-{$pdfs->edict->id}")
                ->assertSeeLink($pdfs->name);
        });
    }
}
