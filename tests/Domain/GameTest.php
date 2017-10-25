<?php
namespace Hero\Tests\Domain;

use Hero\Domain\Player;
use Hero\Domain\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testFirstAttackIsDoneByThePlayerWithTheHigherSpeed()
    {
        $slowPlayerMock = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $slowPlayerMock->expects($this->once())
            ->method('getSpeed')
            ->willReturn(50);
        $slowPlayerMock->expects($this->never())
            ->method('attack');

        $fastPlayerMock = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fastPlayerMock->expects($this->once())
            ->method('getSpeed')
            ->willReturn(100);
        $fastPlayerMock->expects($this->once())
            ->method('attack')
            ->with($slowPlayerMock);

        $game = new Game($fastPlayerMock, $slowPlayerMock);
        $game->playRound();
    }
}
