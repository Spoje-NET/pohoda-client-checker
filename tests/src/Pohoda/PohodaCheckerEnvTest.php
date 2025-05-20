<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mServer\Client;
use Ease\Shared;

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
