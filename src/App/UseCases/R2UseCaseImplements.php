<?php
namespace src\App\UseCases;

class R2UseCaseImplements implements R2UseCase
{
    public function normalizeChange(R2InputData $r2InputData):string
    {
        $changes = [];

        $menusCost = $r2InputData->getMenusCost();
        $totalMoney = $r2InputData->getTotalMoney();

        if ($menusCost > $totalMoney) {
            throw ("金額不足\n");
        }

        $totalChange = $totalMoney - $menusCost;

        foreach ($r2InputData->getVendingMachineCoins() as $coinType => $coinNum) {
            if ($coinNum == 0) {
                continue;
            }
            if ($totalChange < $coinType) {
                continue;
            }

            $numCoin = floor($totalChange / $coinType);

            $diff = 0;

            if ($numCoin > $coinNum) {
                $diff = ($numCoin - $coinNum) * $coinType;
                $numCoin = $coinNum;
            }

            $changes[] = "$coinType $numCoin";
            $totalChange = ($totalChange % $coinType) + $diff;

            if ($totalChange == 0) {
                break;
            }
        }

        return join(' ', $changes);
    }
}
