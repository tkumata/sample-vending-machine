<?php
namespace src\App\UseCases;

class R1InputData
{
    private array $coins;
    private string $menu;

    // @todo This is part of master data of DB. So implement to repogitory.
    private array $menusCost = [
        'cola' => 120,
        'coffee' => 150,
        'energy_drink' => 210
    ];

    private array $coinTypes = [
        '500',
        '100',
        '50',
        '10'
    ];


    public function __construct($coins, $menu)
    {
        $this->coins = $coins;
        $this->menu = $menu;
    }


    /**
     *
     */
    public function getCoinTypes(): array
    {
        return $this->coinTypes;
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
