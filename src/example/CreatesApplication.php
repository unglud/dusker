<?php

namespace Tests;

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
        $app = require __DIR__ . '/../vendor/unglud/dusker/src/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

}
