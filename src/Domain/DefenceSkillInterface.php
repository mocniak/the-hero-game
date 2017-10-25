<?php

namespace Hero\Domain;

interface DefenceSkillInterface
{
    public function modifyDamage(int $damage): int;
}