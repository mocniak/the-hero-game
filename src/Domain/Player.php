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

    public function attack(Player $defender)
    {
        $strikes = [$this->strength];
        /** @var AttackSkillInterface $attackSkill */
        foreach ($this->attackSkills as $attackSkill) {
            $strikes = $attackSkill->modifyStrikes($strikes);
        }
        $defender->takeAHit($strikes);
    }

    public function takeAHit(array $strikes)
    {
        foreach ($strikes as $strike) {
            if (!$this->amILuckyThisTime()) {
                $this->health = $this->health - ($strike - $this->defence);
            }
        }
    }

    public function areYouDead(): bool
    {
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    private function amILuckyThisTime(): bool
    {
        if ($this->luck + rand(0, 99) > 100) {
            return true;
        }

        return false;
    }
}