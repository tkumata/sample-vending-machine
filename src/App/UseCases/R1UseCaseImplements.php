<?php
namespace src\App\UseCases;

use Exception;

class R1UseCaseImplements implements R1UseCase
{
    public function calcChange(R1InputData $r1InputData): string
    {
        $menusCost = $r1InputData->getMenusCost();
        $totalMoney = $r1InputData->getTotalMoney();
        $coinTypes = $r1InputData->getCoinTypes();

        if ($menusCost > $totalMoney) {
            throw new Exception("金額不足\n");
        }

        $totalChange = $totalMoney - $menusCost;

        if ($totalChange == 0) {
            return 'nochange';
        }

        $changes = [];

        foreach ($coinTypes as $changeCoinType) {
            if ($totalChange < $changeCoinType) {
                continue;
            }

            $numCoin = floor($totalChange / $changeCoinType);
            $changes[] = "$changeCoinType $numCoin";
            $totalChange = $totalChange % $changeCoinType;

            if ($totalChange == 0) {
                break;
            }
        }

        return join(' ', $changes);
    }
}
