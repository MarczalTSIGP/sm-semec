<?php

namespace Tests\Browser\Admin\ServantCompletaryData\Movements;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Movement;
use App\Models\Unit;

class DestroyTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    /** @var \App\Models\Unit */
    protected $unit;

    /** @var \App\Models\Movement */
    protected $movement;

    /*public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->unit = Unit::factory()->create();
        $this->movement = Movement::factory()->create();
    }*/

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/servants/1/contracts/1/completary-datas');

            $browser->scrollIntoView('.table.table tbody');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->movement->occupation);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->movement->occupation);
            });
        });
    }
}
