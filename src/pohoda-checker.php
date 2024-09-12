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

require_once '../vendor/autoload.php';

$options = getopt('o::e::', ['output::', 'environment::']);
\Ease\Shared::init(['POHODA_URL', 'POHODA_USERNAME', 'POHODA_PASSWORD', 'POHODA_ICO'], \array_key_exists('environment', $options) ? $options['environment'] : '../.env');
$destination = \array_key_exists('output', $options) ? $options['output'] : \Ease\Shared::cfg('RESULT_FILE', 'php://stdout');

if (\Ease\Shared::cfg('EASE_LOGGER', false) === false) {
    \define('EASE_LOGGER', 'console');
}

$client = new \mServer\Client();

if (strtolower(\Ease\Shared::cfg('APP_DEBUG', 'false')) === 'true') {
    $client->logBanner();
}

$result = $client->isOnline();
$client->addStatusMessage(_('Connection') . ' ' . ($result ? 'OK' : 'problem'), $result ? 'success' : 'error');
$checkResult = ($result === false);

$written = file_put_contents($destination, json_encode($checkResult, \Ease\Shared::cfg('DEBUG') ? \JSON_PRETTY_PRINT : 0));
$client->addStatusMessage(sprintf(_('Saving result to %s'), $destination), $written ? 'success' : 'error');

// ? exit($written ? 0 : 1);
exit($result === false ? 1 : 0);
