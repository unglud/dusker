<?php
declare(strict_types=1);

namespace Dusker\Bootstrap;

use Dotenv\Dotenv;
use Dusker\Application;

/**
 * Class LoadEnvironmentVariables
 *
 * @package Dusker\Bootstrap
 */
class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Dusker\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        (new Dotenv($app->environmentPath(), $app->environmentFile()))->load();
    }
}
