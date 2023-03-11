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

        foreach ($r2InputData->getVendingMachineCoins() as $coinType => $coinStock) {
            if ($coinStock == 0) {
                continue;
            }
            if ($totalChange < $coinType) {
                continue;
            }

            $numCoinType = floor($totalChange / $coinType);
            $diff = 0;

            if ($numCoinType > $coinStock) {
                $diff = ($numCoinType - $coinStock) * $coinType;
                $numCoinType = $coinStock;
            }

            $changes[] = "$coinType $numCoinType";
            $totalChange = ($totalChange % $coinType) + $diff;

            if ($totalChange == 0) {
                break;
            }
        }

        if ($totalChange != 0) {
            throw new Exception("おつり不足\n");
        }

        return join(' ', $changes);
    }
}
