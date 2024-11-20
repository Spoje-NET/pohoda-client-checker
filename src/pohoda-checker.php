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

\define('APP_NAME', 'mPohoda Check');

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

$result['status'] = $client->isOnline();
$client->addStatusMessage(_('Connection').' '.($result['status'] ? 'OK' : 'problem'), $result['status'] ? 'success' : 'error');

$xml = $client->lastCurlResponse;

// Ensure the response is a valid XML string
if (strpos((string) $xml, '<?xml') !== 0) {
    $client->addStatusMessage(_('No XML response'), 'error');
    $result['message'] = $client->lastCurlError;
} else {
    $client->addStatusMessage(_('XML response received'), 'success');
    libxml_use_internal_errors(true);
    $objXmlDocument = simplexml_load_string($xml);

    if ($objXmlDocument === false) {
        $result['message'] = 'Invalid XML';
        $result['status'] = false;
        $client->addStatusMessage(_('There were errors parsing the XML file'), 'error');

        foreach (libxml_get_errors() as $error) {
            $client->addStatusMessage($error->message, 'debug');
            $result['errors'][] = $error->message;
        }
    } else {
        $objJsonDocument = json_encode($objXmlDocument);
        $result = json_decode($objJsonDocument, true);
    }
}

$written = file_put_contents($destination, json_encode($result, \Ease\Shared::cfg('DEBUG') ? \JSON_PRETTY_PRINT : 0));
$client->addStatusMessage(sprintf(_('Saving result to %s'), $destination), $written ? 'success' : 'error');

exit($written ? 0 : 1);
