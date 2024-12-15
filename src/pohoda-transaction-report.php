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

namespace Pohoda;

require_once '../vendor/autoload.php';

\define('APP_NAME', 'Pohoda Transaction Reporter');

$options = getopt('o::e::', ['output::environment::']);

\Ease\Shared::init(['POHODA_URL', 'POHODA_USERNAME', 'POHODA_PASSWORD', 'POHODA_ICO', 'POHODA_IBAN'], \array_key_exists('environment', $options) ? $options['environment'] : '../.env');
$localer = new \Ease\Locale('cs_CZ', '../i18n', 'pohoda-transaction-report');
$exitCode = 0;
$transactionList = [];

$banker = new \Pohoda\BankProbe(\Ease\Shared::cfg('POHODA_BANK_IDS', ''));

$destination = \array_key_exists('output', $options) ? $options['output'] : \Ease\Shared::cfg('RESULT_FILE', 'php://stdout');

if (strtolower(\Ease\Shared::cfg('APP_DEBUG', 'false')) === 'true') {
    $banker->logBanner(\Ease\Shared::appName().' v'.\Ease\Shared::appVersion());
}

$banker->setScope(\Ease\Shared::cfg('REPORT_SCOPE', false) ? \Ease\Shared::cfg('REPORT_SCOPE', 'yesterday') : 'this_year');

$payments = [
    'source' => \Ease\Logger\Message::getCallerName($banker),
    'account' => $banker->accuntNumber(),
    'status' => $banker->lastResponseMessage,
    'in' => [],
    'out' => [],
    'in_total' => 0,
    'out_total' => 0,
    'in_sum_total' => 0,
    'out_sum_total' => 0,
    'iban' => $banker->getIban(),
    'from' => $banker->getSince()->format('Y-m-d'),
    'to' => $banker->getUntil()->format('Y-m-d'),
];

try {
    if ($banker->isOnline()) {
        if (\Ease\Shared::cfg('REPORT_SCOPE', false)) {
            $transactionList = $banker->transactionsFromTo();
        } else {
            $transactionList = $banker->getColumnsFromPohoda();
        }
    } else {
        $banker->addStatusMessage(_('Connection').' problem', 'error');
        $exitCode = 503;
    }
} catch (\mServer\HttpException $ex) {
    $banker->addStatusMessage($ex->getCode().': '.$ex->getMessage(), 'error');
    $payments['message'] = $ex->getCode().': '.$ex->getMessage();
}

if ($transactionList) {
    foreach ($transactionList as $id => $transaction) {
        if (\array_key_exists('bankHeader', $transaction)) {
            if ($banker->bankIDS === $transaction['bankHeader']['account']['ids']) {
                $direction = ($transaction['bankHeader']['bankType'] === 'receipt');

                if (\array_key_exists('bankDetail', $transaction)) {
                    $amount = (float) $transaction['bankDetail']['bankItem']['homeCurrency']['unitPrice'];
                } else {
                    $amount = (float) $transaction['bankSummary']['homeCurrency']['priceNone'];
                }

                $payments[$direction ? 'in' : 'out'][$id] = $amount;
                $payments[$direction ? 'in_sum_total' : 'out_sum_total'] += $amount;
                ++$payments[$direction ? 'in_total' : 'out_total'];
            }
        } elseif (\array_key_exists('account', $transaction)) {
            if ($banker->bankIDS === $transaction['account']['ids']) {
                $direction = ($transaction['bankType'] === 'receipt');
            }
        }
    }
}

$written = file_put_contents($destination, json_encode($payments, \Ease\Shared::cfg('DEBUG') ? \JSON_PRETTY_PRINT : 0));
$banker->addStatusMessage(sprintf(_('Saving result to %s'), $destination), $written ? 'success' : 'error');

exit($exitCode ?: ($written ? 0 : 1));
