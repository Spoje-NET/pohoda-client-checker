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

/**
 * Description of BankProbe.
 *
 * @author vitex
 */
class BankProbe extends \mServer\Bank
{
    public string $bankIDS;
    public string $account = '';
    public string $iban;
    protected \DateTime $since;
    protected \DateTime $until;
    /**
     * Scope of data to be processed.
     *
     * @param array<string, string> $options
     */
    public function __construct(string $bankIDS, array $options = [])
    {
        parent::__construct([], $options);
        $this->bankIDS = $bankIDS;
        $this->iban = \Ease\Shared::cfg('POHODA_IBAN', '');
    }

    /**
     * Prepare processing interval.
     *
     * @param string $scope
     *
     * @throws \Exception
     */
    public function setScope($scope): void
    {
        switch ($scope) {
            case 'yesterday':
                $this->since = (new \DateTime('yesterday'))->setTime(0, 0);
                $this->until = (new \DateTime('yesterday'))->setTime(23, 59);

                break;
            case 'two_days_ago':
                $this->since = (new \DateTime('-2 days'))->setTime(0, 0);
                $this->until = (new \DateTime('-2 days'))->setTime(23, 59);

                break;
            case 'last_week':
                $this->since = new \DateTime('first day of last week');
                $this->until = new \DateTime('last day of last week');

                break;
            case 'current_month':
                $this->since = new \DateTime('first day of this month');
                $this->until = new \DateTime();

                break;
            case 'last_month':
                $this->since = new \DateTime('first day of last month');
                $this->until = new \DateTime('last day of last month');

                break;
            case 'last_two_months':
                $this->since = (new \DateTime('first day of last month'))->modify('-1 month');
                $this->until = (new \DateTime('last day of last month'));

                break;
            case 'previous_month':
                $this->since = new \DateTime('first day of -2 month');
                $this->until = new \DateTime('last day of -2 month');

                break;
            case 'two_months_ago':
                $this->since = new \DateTime('first day of -3 month');
                $this->until = new \DateTime('last day of -3 month');

                break;
            case 'this_year':
                $this->since = new \DateTime('first day of January '.date('Y'));
                $this->until = new \DateTime('last day of December'.date('Y'));

                break;
            case 'January':  // 1
            case 'February': // 2
            case 'March':    // 3
            case 'April':    // 4
            case 'May':      // 5
            case 'June':     // 6
            case 'July':     // 7
            case 'August':   // 8
            case 'September':// 9
            case 'October':  // 10
            case 'November': // 11
            case 'December': // 12
                $this->since = new \DateTime('first day of '.$scope.' '.date('Y'));
                $this->until = new \DateTime('last day of '.$scope.' '.date('Y'));

                break;

            default:
                throw new \Exception('Unknown scope '.$scope);
        }

        $this->since = $this->since->setTime(0, 0);
        $this->until = $this->until->setTime(23, 59);
    }

    public function getUntil(): \DateTime
    {
        return $this->until;
    }

    public function getSince(): \DateTime
    {
        return $this->since;
    }

    public function accuntNumber(): string
    {
        return $this->account;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * Get transactions from Pohoda.
     *
     * @return array<mixed>
     */
    public function transactionsFromTo(): array
    {
        $conds = [];
        $conds['dateFrom'] = $this->getSince()->format('Y-m-d');
        $conds['dateTill'] = $this->getUntil()->format('Y-m-d');

        return $this->getColumnsFromPohoda(['*'], $conds);
    }

    /**
     * Get columns from Pohoda.
     *
     * @param array<string>         $columns
     * @param array<string, string> $conditions
     *
     * @return array<mixed>
     */
    public function getColumnsFromPohoda($columns = ['id'], $conditions = []): array
    {
        $data = parent::getColumnsFromPohoda($columns, $conditions);

        if (!empty($data)) {
            $first = current($data);

            if (\array_key_exists('bankHeader', $first)) {
                $this->account = $first['bankHeader']['paymentAccount']['accountNo'];
            } elseif (\array_key_exists('account', $first)) {
                $this->account = $first['account']['ids'];
            }
        }

        return (array) $data;
    }
}
