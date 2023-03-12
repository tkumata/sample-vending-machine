<?php
namespace src\App\UseCases;

use Exception;

class R2UseCaseImplements implements R2UseCase
{
    public function normalizeChange(R2InputData $r2InputData): string
    {
        $changes = [];

        $menusCost = $r2InputData->getMenusCost();
        $totalMoney = $r2InputData->getTotalMoney();

        if ($menusCost > $totalMoney) {
            throw new Exception("金額不足\n");
        }

        $totalChange = $totalMoney - $menusCost;

        if ($totalChange == 0) {
            return 'nochange';
        }

        foreach ($r2InputData->getVendingMachineCoins() as $coinType => $coinStock) {
            if ($coinStock == 0) {
                continue;
            }

            if ($totalChange < $coinType) {
                continue;
            }

            $numCoinType = floor($totalChange / $coinType);
            $changeCarryOver = 0;

            if ($numCoinType > $coinStock) {
                $changeCarryOver = ($numCoinType - $coinStock) * $coinType;
                $numCoinType = $coinStock;
            }

            $changes[] = "$coinType $numCoinType";
            $totalChange = ($totalChange % $coinType) + $changeCarryOver;

            if ($totalChange == 0) {
                break;
            }
        }

        $change = join(' ', $changes);

        if ($totalChange != 0) {
            $change = 'shortage';
        }

        return $change;
    }
}
