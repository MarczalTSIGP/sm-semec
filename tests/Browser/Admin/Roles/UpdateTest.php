<?php

namespace Tests\Browser\Admin\Roles;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;

class UpdateTest extends DuskTestCase
{
    /** @var \App\Models\Role*/
    protected $role;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testFilledFields(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.role', $this->role->id));

            $browser->assertInputValue('name', $this->role->name);
        });
    }

    public function testSucessfullyUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.role', $this->role->id));

            $newData = Role::factory()->make([
                'name' => 'Educador(a) Infantil',
            ]);

            $browser->type('name', $newData->name)
                    ->press('Atualizar Cargo');

            $browser->assertUrlIs(route('admin.roles'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Cargo atualizado com sucesso');
            });
            $browser->with('table.table', function ($table) use ($newData) {
                $table->assertSee($newData->name);
                $table->assertDontSee($this->role->name);
            });
        });
    }

    public function testFailuteUpdate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.role', $this->role->id));

            $browser->type('name', '')
                    ->press('Atualizar Cargo');

            $browser->assertUrlIs(route('admin.update.role', $this->role->id));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.role_name', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });
        });
    }

    public function testUniquenessOnUpdate(): void
    {
        $this->browse(function ($browser) {
            $role = Role::factory()->create();
            $browser->loginAs($this->user)->visit(route('admin.edit.role', $this->role->id));


            $browser->type('name', $role->name)
                    ->press('Atualizar Cargo');

            $browser->with('div.role_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });

            $browser->type('name', $this->role->name)
                    ->press('Atualizar Cargo');

            $browser->assertUrlIs(route('admin.roles'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Cargo atualizado com sucesso');
            });
            $browser->with('table.table', function ($table) {
                $table->assertSee($this->role->name);
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->role = Role::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.edit.role', $this->role->id));

            $backLinkSelector = "#main-card a[href='" . route('admin.roles') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.roles') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Cargos');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Editar Cargo #{$this->role->id}");
        });
    }
}
