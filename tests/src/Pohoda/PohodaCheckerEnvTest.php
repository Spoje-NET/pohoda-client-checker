<?php

declare(strict_types=1);

/**
 * This file is part of the PohodaClientChecker package
 *
 * https://github.com/Spoje-NET/pohoda-client-checker
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ease\Shared;
use mServer\Client;
use PHPUnit\Framework\TestCase;

class PohodaCheckerEnvTest extends TestCase
{
    protected function setUp(): void
    {
        // Načti konfiguraci z test.env
        $envFile = __DIR__.'/../../test.env';
        Shared::init(['POHODA_URL', 'POHODA_USERNAME', 'POHODA_PASSWORD', 'POHODA_ICO'], $envFile);
    }

    public function testConnectionToTestServer(): void
    {
        $client = new Client();
        $this->assertTrue($client->isOnline(), 'Připojení k testovacímu mServeru selhalo.');
    }
}
