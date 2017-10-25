<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 25.10.17
 * Time: 22:41
 */

namespace Mocniak\Hero\Tests\Domain;

use Mocniak\Hero\Domain\AttackSkillInterface;
use Mocniak\Hero\Domain\DefenceSkillInterface;
use Mocniak\Hero\Domain\Player;
use Mocniak\Hero\Domain\Strike;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /** @var Player */
    private $player;
    /** @var AttackSkillInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $attackSkillMock;

    public function setUp()
    {
        $this->attackSkillMock = $this->getMockBuilder(AttackSkillInterface::class)->getMock();
        $attackSkills = [$this->attackSkillMock];
        $defenceSkills = [$this->getMockBuilder(DefenceSkillInterface::class)->getMock()];
        $this->player = new Player("Player", 80, 80, 60, 30, 30, $attackSkills, $defenceSkills);
    }

    public function testPlayersStrikesAreModifiedByHisAttackSkills()
    {
        $strike = new Strike();
        $this->attackSkillMock->expects($this->once())
            ->method('applySkill')
            ->willReturn($strike);
        $this->assertSame($strike,$this->player->getStrikes()[0]);
    }
}
