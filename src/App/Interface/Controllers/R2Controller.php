<?php

namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

class R2Controller
{
    private array $vendingMachineCoins;
    private array $coins;
    private string $menu;

    private array $menusCost = [
        'cola' => 120,
        'coffee' => 150,
        'energy_drink' => 210
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
