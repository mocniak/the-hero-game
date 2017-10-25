<?php

namespace Hero\Domain;

class Game
{
    private $attacker;
    private $defender;

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
    }

    public function playRound()
    {
        $this->attacker->attack($this->defender);
        list($this->attacker, $this->defender) = array($this->defender, $this->attacker);
    }
}