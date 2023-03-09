<?php
namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

use src\App\UseCases\R2InputData;
use src\App\UseCases\R2UseCaseImplements;

class R2Controller
{
    public function __construct()
    {
    }

    public function getChange($vendingMachineCoins, $userInput): string
    {
        try {
            $inputData = new R2InputData($vendingMachineCoins, $userInput);
            $usecase = new R2UseCaseImplements;

            return $usecase->normalizeChange($inputData);
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            exit;
        }
    }
}
