<?php

namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

class R2Controller
{
    private array $vendingMachineCoins;
    private array $userInput;
    private array $coins;
    private string $menu;

    private array $menusCost = [
        'cola' => 120,
        'coffee' => 150,
        'energy_drink' => 210
    ];

    private array $coinTypes = [
        500,
        100,
        50,
        10
    ];

    public function __construct($vendingMachineCoins, $userInput)
    {
        $this->vendingMachineCoins = $vendingMachineCoins;
        $this->coins = $userInput['coins'];
        $this->menu = $userInput['menu'];
    }

    /**
     * getTotalMoney
     * 所持金の合計を返す。
     */
    private function getTotalMoney(): int
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
    private function getMenusCost(): int
    {
        return $this->menusCost[$this->menu];
    }

    /**
     * getChange
     * お釣りの具体値を取得する。
     */
    public function getChange(): string
    {
        if ($this->getMenusCost() > $this->getTotalMoney()) {
            throw ("金額不足\n");
        }
        $totalChange = $this->getTotalMoney() - $this->getMenusCost();
        return $this->normalizeChange($totalChange);
    }

    /**
     * calcChange
     * お釣りの具体値を計算する。
     */
    private function calcChange(int $totalChange): string
    {
        if ($totalChange == 0) {
            return 'nochange';
        }

        $changes = [];

        foreach ($this->coinTypes as $changeCoinType) {
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

    private function makePool($coinTypes, $vendingMachineCoins): array
    {
        $arr = [];
        $i = 0;
        foreach($coinTypes as $type) {
            $arr[$type] = $vendingMachineCoins[$i];
            $i++;
        }
        return $arr;
    }

    /**
     * お釣り最適化
     */
    private function normalizeChange(int $totalChange): string
    {
        $changes = [];

        foreach ($this->vendingMachineCoins as $coinType => $coinNum) {
            if ($coinNum == 0) {
                continue;
            }
            if ($totalChange > $coinType*$coinNum) {
                continue;
            }
            if ($totalChange < $coinType) {
                continue;
            }

            $numCoin = floor($totalChange / $coinType);
            $changes[] = "$coinType $numCoin";
            $totalChange = $totalChange % $coinType;

            if ($totalChange == 0) {
                break;
            }
        }

        return join(' ', $changes);
    }
}
