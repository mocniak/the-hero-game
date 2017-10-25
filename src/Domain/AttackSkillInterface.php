<?php

namespace Hero\Domain;

interface AttackSkillInterface
{
    /** @return int[] */
    public function modifyStrikes(array $strikes): array;
}