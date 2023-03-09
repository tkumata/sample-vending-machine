<?php
namespace src\App\UseCases;

class R2InputData
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

    public function getVendingMachineCoins(): array
    {
        return $this->vendingMachineCoins;
    }

    public function getTotalMoney(): int
    {
        $total = 0;
        foreach ($this->coins as $key => $value) {
            $total = $total + ($key * $value);
        }
        return $total;
    }

    public function getMenusCost(): int
    {
        return $this->menusCost[$this->menu];
    }
}
