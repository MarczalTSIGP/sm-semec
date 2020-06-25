<?php

namespace Tests\Browser\Users\Session;

use App\User;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSucessLogin(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/login')
                    ->type('CPF', $this->user->CPF)
                    ->type('password', 'password')
                    ->press('Entrar')
                    ->assertPathIs('/admin');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Login efetuado com sucesso.');
            });

            $browser->with('div.header', function ($header) {
                $header->assertSee($this->user->name);
                $header->assertSee($this->user->email);
            });
        });
    }

    public function testFailureLogin(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/login')
                    ->type('CPF', $this->user->CPF)
                    ->type('password', 'wrong-password')
                    ->press('Entrar')
                    ->assertPathIs('/admin/login');

            $browser->with('div.alert', function ($flash) {
                $flash->assertSee('Usuário ou senha incorretas.');
            });
        });
    }
}
