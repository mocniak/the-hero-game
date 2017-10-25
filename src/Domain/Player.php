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
     * @var AttackSkillInterface[]
     */
    private $attackSkills;
    /**
     * @var DefenceSkillInterface[]
     */
    private $defenceSkills;

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
        $this->defenceSkills = $defenceSkills;
    }

    public function attack(Player $defender): void
    {
        $strikes = [$this->strength];
        /** @var AttackSkillInterface $attackSkill */
        foreach ($this->attackSkills as $attackSkill) {
            $strikes = $attackSkill->modifyStrikes($strikes);
        }
        foreach ($strikes as $strike) {
            $defender->takeAHit($strike);
        }
    }

    public function takeAHit(int $strike): void
    {
        if (!$this->amILuckyThisTime()) {
            $damage = $strike - $this->defence;
            /** @var DefenceSkillInterface $defenceSkill */
            foreach ($this->defenceSkills as $defenceSkill) {
                $damage = $defenceSkill->modifyDamage($damage);
            }
            $this->health = $this->health - $damage;
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