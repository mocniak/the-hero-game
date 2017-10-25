<?php

namespace Hero\Domain;

class Player
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $health;
    /**
     * @var int
     */
    private $strength;
    /**
     * @var int
     */
    private $defence;
    /**
     * @var int
     */
    private $speed;
    /**
     * @var int
     */
    private $luck;
    /**
     * @var array
     */
    private $attackSkills;

    public function __construct(
        string $name,
        int $health,
        int $strength,
        int $defence,
        int $speed,
        int $luck,
        array $attackSkills,
        array $defenceSkills
    )
    {
        $this->name = $name;
        $this->health = $health;
        $this->strength = $strength;
        $this->defence = $defence;
        $this->speed = $speed;
        $this->luck = $luck;
        $this->attackSkills = $attackSkills;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function attack(Player $target)
    {
    }
}