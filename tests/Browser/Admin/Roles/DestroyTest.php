<?php

namespace Tests\Browser\Admin\Roles;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;

class DestroyTest extends DuskTestCase
{
    /** @var \App\Models\Role */
    protected $role;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testDestroy(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/roles');

            $browser->with("table.table tbody", function ($row) {
                $row->assertSee($this->role->name);
                $row->click('button')
                    ->acceptDialog()
                    ->assertDontSee($this->role->name);
            });
        });
    }
}
