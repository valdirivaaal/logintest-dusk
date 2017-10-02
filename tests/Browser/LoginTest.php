<?php

namespace Tests\Browser;


use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'agent2@r10.co')
                    ->type('password', '123456')
                    ->press('Login')
                    ->waitFor('h3.panel-title', 10)
                    ->assertSee('TEAM');

            $browser->waitFor('.ticket-card')
                    ->click('#cmiddle > stream > div.timelines > div:nth-child(1) > div > div.tl-footer > div.pull-right > a')
                    ->waitForText('Send');

            $name = $browser->value('#main > detail-ticket > div > div > div.r2 > div > div.col-sm-4.hidden-xs.h-100-persen.r.panel-right > div.dt-section.section-profile > div.profile-name');

            $browser->element('.btn-fill')->getLocationOnScreenOnceScrolledIntoView();
            $browser->type('textarea[name=content]', $name.' Halo :)')
                    ->pause(5000)
                    ->press('Send');
            $browser->waitUntilMissing('#main > detail-ticket > div > div');

            $browser->pause(5000)
                    ->clickLink('Logout')
                    ->waitUntilMissing('h3.panel-title', 10)
                    ->assertSee('Login');
        });
    }
}
