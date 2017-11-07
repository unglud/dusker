<?php
declare(strict_types=1);

namespace Dusker;

use Laravel\Dusk\Browser as DuskBrowser;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Browser.
 */
class Browser extends DuskBrowser
{
    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * @param object|string $userId
     * @param null $guard
     * @return string
     * @throws \UnexpectedValueException
     */
    public function loginAs($userId, $guard = null)
    {
        list($login, $password) = [$userId, $guard];

        $endpoint = $this->getEndpoint();

        $this->visit($endpoint . '?' . http_build_query(compact('login', 'password')));

        $this->removeEndpoint();
    }

    /**
     * @return string
     * @throws \UnexpectedValueException
     */
    protected function getEndpoint(): string
    {
        if (!env('LOGIN_ENDPOINT', false)) {
            throw new \UnexpectedValueException('You need to specify path where login endpoint will be placed');
        }
        $fs = new Filesystem();

        $endpointPath = base_path() . env('LOGIN_ENDPOINT');

        if (!$fs->exists($endpointPath) . config('app.endpoint')) {
            $fs->mirror(dirname(__DIR__) . '/endpoint', $endpointPath . dirname(config('app.endpoint')));
        }

        /** @noinspection PhpStrictTypeCheckingInspection */
        return config('app.endpoint');
    }

    protected function removeEndpoint()
    {
        $fs = new Filesystem();
        $endpointPath = base_path() . env('LOGIN_ENDPOINT') . dirname(config('app.endpoint'));
        $fs->remove($endpointPath);
    }

}
