<?php

declare(strict_types=1);

require_once(__DIR__ . "/../vendor/autoload.php");

use src\App\Interface\Controllers\Controller;

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
        try {
            $controller = new Controller($coins, $menu);
            $menuCost = $controller->getMenusCost();
            $totalMoney = $controller->getTotalMoney();

            return $controller->getChange($menuCost, $totalMoney);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            exit;
        }
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
}
