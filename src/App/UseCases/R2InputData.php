<?php
namespace src\App\UseCases;

class R2InputData
{
    // @todo This is part of master data of DB. So implements to repogitory.
    private array $vendingMachineCoins;

    private array $coins;
    private string $menu;

    // @todo This is part of master data of DB. So implement to repogitory.
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
     * Get coins which a vending machine has.
     */
    public function getVendingMachineCoins(): array
    {
        return $this->vendingMachineCoins;
    }


    /**
     * Calculation total input money.
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
     * Price of order.
     */
    public function getMenusCost(): int
    {
        return $this->menusCost[$this->menu];
    }
}
