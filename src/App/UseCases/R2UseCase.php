<?php
namespace src\App\UseCases;

interface R2UseCase
{
    public function normalizeChange(R2InputData $r2InputData):string;
}
