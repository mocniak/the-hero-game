<?php

use Hero\Domain\Game;
use Hero\Domain\MagicShieldDefenceSkill;
use Hero\Domain\Player;
use Hero\Domain\RapidStrikeSkill;

require_once __DIR__ . '/../vendor/autoload.php';

$orderus = new Player(
    "Orderus",
    rand(70, 100),
    rand(70, 80),
    rand(45, 55),
    rand(40, 50),
    rand(10, 30),
    [new RapidStrikeSkill()],
    [new MagicShieldDefenceSkill()]
);
$wildBeast = new Player(
    'Wild Beast',
    rand(60, 90),
    rand(60, 90),
    rand(40, 60),
    rand(40, 60),
    rand(25, 40),
    [],
    []
);
$game = new Game($orderus, $wildBeast);

while (false === $game->isGameOver()) {
    $game->playRound();
}