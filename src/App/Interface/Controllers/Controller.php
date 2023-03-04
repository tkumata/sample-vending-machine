<?php

namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

class Controller
{
    public function __construct()
    {
    }

    /**
     * getTotalMoney
     * 所持金の合計を計算する。
     */
    public function getTotalMoney(array $coins): int
    {
        $total = 0;
        foreach ($coins as $key => $value) {
            $total = $total + ($key * $value);
        }
        return $total;
    }

    /**
     * getMenusCost
     * 注文から費用を取得する。
     */
    public function getMenusCost(string $menu): int
    {
        $menusCost = [
            'cola' => 120,
            'coffee' => 150,
            'energy_drink' => 210
        ];
        return $menusCost[$menu];
    }

    /**
     * getChange
     * お釣りの具体値を取得する。
     */
    public function getChange(int $cost, int $money): string
    {
        if ($cost > $money) {
            throw ("金額不足\n");
        }

        $totalChange = $money - $cost;
        return $this->calcChange($totalChange);
    }

    /**
     * calcChange
     * お釣りの具体値を計算する。
     */
    public function calcChange(int $totalChange): string
    {
        if ($totalChange == 0) {
            return 'nochange';
        }

        $changeCoinTypes = [
            500,
            100,
            50,
            10
        ];

        $changes = [];

        foreach ($changeCoinTypes as $changeCoinType) {
            if ($totalChange < $changeCoinType) continue;

            $numCoin = floor($totalChange / $changeCoinType);
            $changes[] = "$changeCoinType $numCoin";
            $totalChange = $totalChange % $changeCoinType;

            if ($totalChange == 0) break;
        }

        return join(' ', $changes);
    }
}
