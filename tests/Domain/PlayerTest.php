<?php

namespace Hero\Tests\Domain;

use Hero\Domain\AttackSkillInterface;
use Hero\Domain\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testDamageIsSubtractedFromDefendersHealth()
    {
        $health = 100;
        $strength = 70;
        $defence = 50;
        $speed = 100;
        $luck = 0;
        $attacker = new Player('attacker', $health, $strength, $defence, $speed, $luck, [], []);
        $defender = new Player('defender', $health, $strength, $defence, $speed, $luck, [], []);

        $attacker->attack($defender);
        $this->assertEquals($health - ($strength - $defence), $defender->getHealth());
        $this->assertEquals($health, $attacker->getHealth());
    }

    public function testPlayerLosesHealthWhenTakesAHit()
    {
        $health = 100;
        $strength = 70;
        $defence = 50;
        $speed = 100;
        $luck = 0;
        $defender = new Player('defender', $health, $strength, $defence, $speed, $luck, [], []);
        $strike = 60;
        $defender->takeAHit([$strike]);
        $this->assertEquals($health - ($strike - $defence), $defender->getHealth());
    }

    public function testPlayerDoesNotLoseHealthWhenTakesAHitButHasALotOfLuck()
    {
        $health = 100;
        $strength = 70;
        $defence = 50;
        $speed = 100;
        $luck = 100;
        $defender = new Player('defender', $health, $strength, $defence, $speed, $luck, [], []);
        $strike = 60;
        $defender->takeAHit([$strike]);
        $this->assertEquals($health, $defender->getHealth());
    }

    public function testAttackSkillsModifiesStrikes() {
        $health = 100;
        $strength = 70;
        $defence = 50;
        $speed = 100;
        $luck = 0;
        $attackSkillMock = $this->getMockBuilder(AttackSkillInterface::class)
            ->getMock();
        $modifiedStrikes = ['array of strikes'];
        $attackSkillMock->expects($this->once())
            ->method('modifyStrikes')
            ->with([$strength])
            ->willReturn($modifiedStrikes);
        $defenderMock = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $defenderMock->expects($this->once())
            ->method('takeAHit')
            ->with($modifiedStrikes);
        $attacker = new Player('attacker', $health, $strength, $defence, $speed, $luck, [$attackSkillMock], []);
        $attacker->attack($defenderMock);
    }
}
