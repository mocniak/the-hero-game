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
        } else {
            $this->attacker = $player2;
            $this->defender = $player1;
        }
    }

    public function playRound()
    {
        $this->attacker->attack($this->defender);
    }
}