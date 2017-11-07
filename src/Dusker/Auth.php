<?php
declare(strict_types=1);

/**
 * preisvergleich
 * PHP version 7.1
 *
 * @category  preisvergleich
 * @package   preisvergleich
 * @author    Aleksandr Matrosov <aleksandr.matrosov@check24.de>
 * @date      07.11.17
 * @copyright 2017 (c) CHECK24 Vergleichsportal Shopping GmbH
 * @license   check24.de proprietary
 * @link      https://check24.de
 */

namespace Dusker;

/**
 * Class Auth.
 */
class Auth
{
    /**
     * @param $login
     * @param $password
     * @return mixed
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
