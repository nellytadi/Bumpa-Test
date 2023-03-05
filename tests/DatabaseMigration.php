<?php


namespace Tests;


use Illuminate\Support\Facades\Artisan;

trait DatabaseMigration
{
    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static bool $setUpHasRunOnce = false;

    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh --seed');
            static::$setUpHasRunOnce = true;
        }
    }
}