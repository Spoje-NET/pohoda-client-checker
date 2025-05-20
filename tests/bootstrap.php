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

require_once \dirname(__DIR__).'/vendor/autoload.php';

$defaultEnv = \dirname(__DIR__).'/.env';
$testEnv = __DIR__.'/test.env';
$envFile = file_exists($defaultEnv) ? $defaultEnv : $testEnv;

\Ease\Shared::init(['POHODA_URL', 'POHODA_USERNAME', 'POHODA_PASSWORD', 'POHODA_ICO'], $envFile);
