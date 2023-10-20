<?php
/**
 * PHPmServer - Pohoda Access probe
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  (C) 2023 Vitex Software
 */
require_once '../vendor/autoload.php';
\Ease\Shared::init(['POHODA_URL', 'POHODA_USERNAME', 'POHODA_PASSWORD'], array_key_exists(1, $argv) && file_exists($argv[1]) ? $argv[1] : '../.env');
if (\Ease\Shared::cfg('EASE_LOGGER', false) === false) {
    define('EASE_LOGGER', 'console');
}

$client = new \mServer\Client();
if (\Ease\Shared::cfg('APP_DEBUG')) {
    $client->logBanner();
}

$result = $client->isOnline();
$client->addStatusMessage(_('Connection') . ' ' . ($result ? 'OK' : 'problem'), $result ? 'success' : 'error');
exit($result === false ? 1 : 0);
