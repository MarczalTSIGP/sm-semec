<?php

namespace Tests\Browser\Admin\Roles;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;

class CreateTest extends DuskTestCase
{
    /** @var \App\Models\Role */
    protected $role;
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->make([
            'name' => 'Educador(a) Infantil ',
        ]);
        $this->user = User::factory()->create();
    }

    public function testSucessfullyCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.role'));
            $browser->type('name', $this->role->name)
                    ->press('Criar Cargo');

            $browser->assertUrlIs(route('admin.roles'));
            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Cargo cadastrado com sucesso');
            });
        });
    }

    public function testFailureCreate(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.role'));

            $browser->press('Criar Cargo');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Existem dados incorretos! Por favor verifique!');
            });

            $browser->with('div.role_name', function ($flash) {
                $flash->assertSee('O campo nome é obrigatório.');
            });
        });
    }

    public function testUniquenessOnCreate(): void
    {
        $this->browse(function ($browser) {
            $role = Role::factory()->create();
            $browser->loginAs($this->user)->visit(route('admin.new.role'));

            $browser->type('name', $role->name)
                    ->press('Criar Cargo');

            $browser->with('div.role_name', function ($flash) {
                $flash->assertSee('O campo nome já está sendo utilizado.');
            });
        });
    }

    public function testAssertLinksPresent(): void
    {
        $this->role = Role::factory()->create();

        $this->browse(function ($browser) {
            $browser->loginAs($this->user)->visit(route('admin.new.role'));

            $backLinkSelector = "#main-card a[href='" . route('admin.roles') . "']";
            $browser->assertSeeIn($backLinkSelector, 'Voltar');

            $rootBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.dashboard') . "']";
            $secondBreadcrumbSelector = ".breadcrumb-item a[href='" . route('admin.roles') . "']";
            $thirdBreadcrumbSelector = ".breadcrumb li:nth-child(3)";
            $browser->assertSeeIn($rootBreadcrumbSelector, 'Página Inicial');
            $browser->assertSeeIn($secondBreadcrumbSelector, 'Cargos');
            $browser->assertSeeIn($thirdBreadcrumbSelector, "Novo Cargo");
        });
    }
}
