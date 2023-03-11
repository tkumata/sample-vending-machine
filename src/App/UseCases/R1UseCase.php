<?php
namespace src\App\UseCases;

interface R1UseCase
{
    public function calcChange(R1InputData $r1InputData):string;
}
