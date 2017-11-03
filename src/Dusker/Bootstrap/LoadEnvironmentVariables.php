<?php

declare(strict_types=1);

namespace Dusker\Bootstrap;

use Dotenv\Dotenv;
use Dusker\Application;

/**
 * Class LoadEnvironmentVariables.
 */
class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param \Dusker\Application $app
     */
    public function bootstrap(Application $app)
    {
        (new Dotenv($app->environmentPath(), $app->environmentFile()))->load();
    }
}
