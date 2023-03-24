<?php

namespace Tests\Browser\Servants\Session;

use Tests\DuskTestCase;
use App\Models\Servant;

class LogoutTest extends DuskTestCase
{
    public function testSuccessLogout(): void
    {
        $servant = Servant::factory()->create();
        $this->browse(function ($browser) use ($servant) {
            $browser->loginAs($servant, 'servant')->visit('/servant')
                ->click('@HeaderDropdownUserOptions')
                ->click('@HeaderLogoutAction')
                ->assertPathIs('/servant/login');
        });
    }
}
