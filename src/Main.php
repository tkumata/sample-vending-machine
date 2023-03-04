<?php

declare(strict_types=1);

/**
 * メインクラス。
 * 原則ここにロジックは書かないこと。
 */
class Main
{
    /**
     * 処理の開始地点
     *
     * @param array $coins 投入額
     * @param string $menu 注文
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function runSimply(array $coins, string $menu): string
    {
        $cost = Main::getMenusCost($menu);
        if ($cost > Main::getTotalMoney($coins)) {
            return "金額不足";
        }

        return Main::getChange($cost, Main::getTotalMoney($coins));
    }

    /**
     * 処理の開始地点。ただし自動販売機がいくつ硬貨を持っているかも合わせて処理する
     *
     * @param array $vendingMachineCoins 自販機に補充される硬貨
     * @param array $userInput 投入額と注文。前述の$coinsと$menuをあわせたもの
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function run(array $vendingMachineCoins, array $userInput): string
    {
        return "do implementation";
    }

    private static function getTotalMoney(array $coins): int
    {
        $total = 0;
        foreach ($coins as $key => $value) {
            $total = $total + ($key * $value);
        }
        return $total;
    }

    private static function getMenusCost($menu): int
    {
        $menusCost = [
            'cola' => 120,
            'coffee' => 150,
            'energy_drink' => 210
        ];
        return $menusCost[$menu];
    }

    private static function getChange($cost, $money): string
    {
        $totalChange = $money - $cost;
        return Main::calcChange($totalChange);
    }

    private static function calcChange($totalChange): string
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
