<?php

namespace Hero\Domain;

class RapidStrikeSkill implements AttackSkillInterface
{
    /** @return int[] */
    public function modifyStrikes(array $strikes): array
    {
        if (rand(1, 10) == 1) {
            return array_merge($strikes, $strikes);
        }
        return $strikes;
    }
}