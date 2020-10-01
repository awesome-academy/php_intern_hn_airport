<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testLoginFunctionFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_AGENCY_URL') . '/login')
                ->type('phone', '0321456987')
                ->type('password', '123456789')
                ->press('#btn-login')
                ->assertPathIs('/login');
        });
    }

    public function testLoginFunctionSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_AGENCY_URL') . '/login')
                ->type('phone', '0987654321')
                ->type('password', '123')
                ->press('#btn-login')
                ->assertPathIs('/requests/create');
        });
    }

    public function testRegisterSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_AGENCY_URL') . '/login')
                ->press('#btn-register')
                ->assertPathIs('/signup');
        });
    }
}
