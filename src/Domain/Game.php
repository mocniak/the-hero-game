<?php

namespace Hero\Domain;

class Game
{
    const TURNS = 20;

    private $attacker;
    private $defender;
    /** @var integer */
    private $roundCounter;
    /** @var boolean */
    private $gameOver;

    public function __construct(Player $player1, Player $player2)
    {
        if ($player1->getSpeed() > $player2->getSpeed()) {
            $this->attacker = $player1;
            $this->defender = $player2;
        } else if ($player1->getSpeed() < $player2->getSpeed()) {
            $this->attacker = $player2;
            $this->defender = $player1;
        } else {
            if ($player1->getLuck() > $player2->getLuck()) {
                $this->attacker = $player1;
                $this->defender = $player2;
            } else if ($player1->getLuck() < $player2->getLuck()) {
                $this->attacker = $player2;
                $this->defender = $player1;
            } else {
                throw new \RuntimeException('Both players has same speed and luck');
            }
        }
        $this->roundCounter = 0;
        $this->gameOver = false;
    }

    public function playRound()
    {
        $this->roundCounter++;

        $this->attacker->attack($this->defender);

        if ($this->defender->areYouDead() || $this->roundCounter >= self::TURNS) {
            $this->gameOver = true;
        }

        // flip players
        list($this->attacker, $this->defender) = array($this->defender, $this->attacker);
    }

    public function isGameOver(): bool
    {
        return $this->gameOver;
    }
}