<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddFilesTest extends DuskTestCase
{
    public function testIcsAddFileAndCheckIfAddedSomething()
    {
        //php artisan dusk --filter=AddFilesTest --env=testing
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@addFile')
                    ->attach('@addIcs', base_path("public/ALG3.ics"))
                    ->click('@sendIcs')
                    ->visit('/courses')
                    ->assertsee('ALG3');
        });
    }

    public function testCsvAddFileAndCheckIfAddedSomething()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@addFile')
                    ->screenshot('teeeeeest1')
                    ->attach('@addCsv', base_path("public/EtudiantsGroupes10Oct.xlsx_-_EtudiantsGroupesLast.csv"))
                    ->screenshot('teeeeeest2')
                    ->click('@sendCsv')
                    ->screenshot('finished')
                    ->visit('/students')
                    ->screenshot('testvisit')
                    ->assertsee('55427');
        });        
    }
}
