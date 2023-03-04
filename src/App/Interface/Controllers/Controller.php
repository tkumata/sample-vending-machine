<?php

namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

class Controller
{
    public function __construct()
    {
    }

    public function getTotalMoney(array $coins): int
    {
        $total = 0;
        foreach ($coins as $key => $value) {
            $total = $total + ($key * $value);
        }
        return $total;
    }

    public function getMenusCost($menu): int
    {
        $menusCost = [
            'cola' => 120,
            'coffee' => 150,
            'energy_drink' => 210
        ];
        return $menusCost[$menu];
    }

    public function getChange($cost, $money): string
    {
        if ($cost > $money) {
            throw ("金額不足\n");
        }

        $totalChange = $money - $cost;
        return $this->calcChange($totalChange);
    }

    public function calcChange($totalChange): string
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
