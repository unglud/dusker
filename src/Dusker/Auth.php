<?php
declare(strict_types=1);

namespace Dusker;

/**
 * Class Auth.
 */
class Auth
{
    /**
     * @param $login
     * @param $password
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function login($login, $password)
    {
        if (!env('LOGIN_IMPLEMENTATION', false)) {
            throw new \UnexpectedValueException('You need to setup path to your login class implementation in .env');
        }

        /** @noinspection PhpIncludeInspection */
        /** @noinspection UsingInclusionReturnValueInspection */
        $loginManager = require dirname(__DIR__, 5) . env('LOGIN_IMPLEMENTATION', false);

        return $loginManager->login($login, $password);
    }
}
