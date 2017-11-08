<?php

namespace Tests;

use Dusker\Browser;
use Illuminate\Contracts\Console\Kernel;

/**
 * Trait CreatesApplication.
 */
trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Dusker\Application
     */
    public function createApplication()
    {
        /* @noinspection PhpIncludeInspection */
        /* @noinspection UsingInclusionReturnValueInspection */
        $app = require __DIR__ . '/../vendor/unglud/dusker/src/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param $driver
     *
     * @return Browser
     */
    protected function newBrowser($driver): Browser
    {
        return new Browser($driver);
    }
}
