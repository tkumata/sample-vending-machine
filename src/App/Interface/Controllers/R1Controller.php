<?php
namespace src\App\Interface\Controllers;

require_once(__DIR__ . "/../../../../vendor/autoload.php");

use Exception;
use src\App\UseCases\R1InputData;
use src\App\UseCases\R1UseCaseImplements;

class R1Controller
{
    public function __construct()
    {
    }

    public function getChange($coins, $menu): string
    {
        try {
            $inputData = new R1InputData($coins, $menu);
            $usecase = new R1UseCaseImplements;
            return $usecase->calcChange($inputData);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            exit;
        }
    }
}
