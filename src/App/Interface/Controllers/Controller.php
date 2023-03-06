<?php

namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

class Controller
{
    private array $coins;
    private string $menu;

    private array $menusCost = [
        'cola' => 120,
        'coffee' => 150,
        'energy_drink' => 210
    ];

    private array $changeCoinTypes = [
        500,
        100,
        50,
        10
    ];

    public function __construct($coins, $menu)
    {
        $this->menu = $menu;
        $this->coins = $coins;
    }

    /**
     * getTotalMoney
     * 所持金の合計を返す。
     */
    public function getTotalMoney(): int
    {
        $total = 0;
        foreach ($this->coins as $key => $value) {
            $total = $total + ($key * $value);
        }
        return $total;
    }

    /**
     * getMenusCost
     * 品名から価格を返す。
     */
    public function getMenusCost(): int
    {
        return $this->menusCost[$this->menu];
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

        $changes = [];

        foreach ($this->changeCoinTypes as $changeCoinType) {
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
