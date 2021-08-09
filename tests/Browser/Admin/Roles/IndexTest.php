<?php

namespace Tests\Browser\Admin\Roles;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Role;
use App\Models\User;

class IndexTest extends DuskTestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndexList(): void
    {
        $roles = Role::factory()->count(3)->create();
        $roles = $roles->sortBy('name')->reverse();

        $this->browse(function ($browser) use ($roles) {
            $browser->loginAs($this->user)->visit('/admin/roles');

            $browser->with("table.table tbody", function ($row) use ($roles) {
                $pos = 0;
                foreach ($roles as $role) {
                    $pos += 1;
                    $baseSelector = "tr:nth-child({$pos}) ";

                    $editSelector = $baseSelector . "a[href='" .
                     route('admin.edit.role', $role->id) . "']";
                    $deleteSelector = $baseSelector . "form[action='" .
                    route('admin.destroy.role', $role->id) . "']";
                    $row->assertPresent($editSelector);
                    $row->assertPresent($deleteSelector);
                }
            });
        });
    }

    public function testSearchField(): void
    {
        $role = Role::factory()->create(['name' => 'Role name']);

        $this->browse(function ($browser) use ($role) {
            $browser->loginAs($this->user);

            $browser->visit('/admin/roles')
                    ->type('#search_input', $role->name)
                    ->press('#search')
                    ->assertUrlIs(route('admin.search.roles', $role->name));

            $term = time();
            $browser->type('#search_input', $term);
            $browser->keys('#search_input', '{enter}')->assertUrlIs(route('admin.search.roles', $term));

            $browser->assertDontSee($role->name);
        });
    }

    public function testAssertLinksPresent(): void
    {
        Role::factory()->count(22)->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit('/admin/roles');

            $newLinkSelector = "#main-card a[href='" . route('admin.new.role') . "']";
            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumSelector = ".breadcrumb li:nth-child(2)";

            $browser->assertSeeIn($newLinkSelector, 'Novo Cargo');
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumSelector, 'Cargos');

            $browser->with('.pagination', function ($pagination) {
                $pagination->assertSee('1');
                $pagination->assertSeeLink('2');
            });
        });
    }
}
