<?php

namespace Hero\Domain;

class MagicShieldDefenceSkill implements DefenceSkillInterface
{
    public function modifyDamage(int $damage): int
    {
        if (rand(1, 10) <= 2) {
            echo 'Magic Shield!' . PHP_EOL;
            return $damage / 2;
        }
        return $damage;
    }
}