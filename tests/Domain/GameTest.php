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

        return ['game' => $game, 'slowPlayer' => $slowPlayerMock];
    }

    public function testIfBothPlayersHaveSameSpeedFirstAttackIsDoneByTheOneWithHighestLuck()
    {
        $unluckyPlayer = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $unluckyPlayer->expects($this->any())
            ->method('getSpeed')
            ->willReturn(50);
        $unluckyPlayer->expects($this->any())
            ->method('getLuck')
            ->willReturn(50);
        $unluckyPlayer->expects($this->never())
            ->method('attack');

        $luckyPlayer = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $luckyPlayer->expects($this->any())
            ->method('getSpeed')
            ->willReturn(50);
        $luckyPlayer->expects($this->any())
            ->method('getLuck')
            ->willReturn(100);
        $luckyPlayer->expects($this->once())
            ->method('attack')
            ->with($unluckyPlayer);

        $game = new Game($luckyPlayer, $unluckyPlayer);
        $game->playRound();
    }

    /**
     * @depends testFirstAttackIsDoneByThePlayerWithTheHigherSpeed
     */
    public function testAfterOneRoundPlayersSwitchRoles(array $array)
    {
        /** @var Game $game */
        $game = $array['game'];
        $slowPlayer = $array['slowPlayer'];
        $slowPlayer->expects($this->once())
            ->method('attack');
        $game->playRound();
    }

    public function testGameEndsWhenOneOfThePlayerDies() {
        $slowPlayerMock = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $slowPlayerMock->expects($this->once())
            ->method('getSpeed')
            ->willReturn(50);
        $slowPlayerMock->expects($this->once())
            ->method('areYouDead')
            ->willReturn(true);

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
        $this->assertTrue($game->isGameOver());
    }
}
