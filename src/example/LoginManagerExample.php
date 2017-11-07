<?php

declare(strict_types=1);

namespace Tests;

/**
 * Class LoginManager.
 */
class LoginManagerExample
{
    /**
     * @param $login
     * @param $password
     *
     * @return string
     */
    public function login($login, $password)
    {
        return 'ok';
    }
}

return new LoginManager();
