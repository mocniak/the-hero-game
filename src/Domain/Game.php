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
                throw new \RuntimeException('Both players have same speed and luck');
            }
        }
        $this->roundCounter = 0;
        $this->gameOver = false;
    }

    public function playRound()
    {
        $this->roundCounter++;

        echo '==== ROUND ' . $this->roundCounter . ' ====' . PHP_EOL;
        echo $this->attacker->getName() . ' attacks ' . $this->defender->getName() . '!' . PHP_EOL;

        $this->attacker->attack($this->defender);

        echo $this->defender->getName() . ' has ' . $this->defender->getHealth(). 'HP left.'.PHP_EOL;

        if ($this->defender->areYouDead()) {
            $this->gameOver = true;

            echo 'Player ' . $this->defender->getName() . ' dies!' . PHP_EOL;
            echo 'Player ' . $this->attacker->getName() . ' wins!' . PHP_EOL;
        } else if ($this->roundCounter >= self::TURNS) {
            $this->gameOver = true;

            echo 'End of the game, limit of ' . self::TURNS . ' rounds reached.' . PHP_EOL;
        }
        if ($this->gameOver) {
            echo '==== GAME OVER ====' . PHP_EOL;
        }

        // flip players
        list($this->attacker, $this->defender) = array($this->defender, $this->attacker);
    }

    public function isGameOver(): bool
    {
        return $this->gameOver;
    }
}