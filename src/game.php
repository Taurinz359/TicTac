<?php

namespace Game;

use function cli\line;
use function cli\prompt;

function run()
{
    system('clear');
    showTutorial();
    startGame();
}

function startGame()
{
    $currentGameState = [
        " ", " ", " ",
        " ", " ", " ",
        " ", " ", " "
    ];
    $moveNumber = 0;
    $maxSteps = 9;
    $countMoveForCheck = 3;
    while ($moveNumber < $maxSteps) {
        $xO = $moveNumber % 2 === 0 ? "X" : "O";
        line("Move {$xO}: ");
        $position = getPositionFromInput();
        if ($currentGameState[$position] !== " ") {
            line("This position is busy, Try again!");
            continue;
        }
        system('clear');
        $currentGameState[$position] = $xO;
        showCurrentGameStateTable($currentGameState);
        if ($countMoveForCheck < $moveNumber) {
            $winner = checkWinner($currentGameState);
            if ($winner != null) {
                line($winner);
                exit;
            }
        }
        ++$moveNumber;
    }
    line("oOps it is Draw! :c ");
}

function checkWinner(array $currentGameState): ?string
{
    $winPositions = [
        [0, 1, 2],
        [0, 3, 6],
        [0, 4, 8],
        [1, 4, 7],
        [2, 5, 8],
        [2, 4, 6],
        [3, 4, 5],
        [6, 7, 8]
    ];

    foreach ($winPositions as $value) {
        [$first, $second, $thirth] = $value;
        $line = $currentGameState[$first] . $currentGameState[$second] . $currentGameState[$thirth];
        if ($line === "XXX") {
            return "X the Winner!";
        }
        if ($line === "OOO") {
            return "X the Winner!";
        }
    }
    return null;
}

function showTutorial()
{
    echo <<<EOD
    =========================================================
    =========================================================
            HOW TO PLAY: input number of cell you chose:
            +---+---+---+
            | 1 | 2 | 3 |
            +---+---+---+
            | 4 | 5 | 6 |
            +---+---+---+
            | 7 | 8 | 9 |
            +---+---+---+
    =========================================================
    =========================================================
    EOD;
}

function showCurrentGameStateTable(array $XOdataArray)
{ //this function drawing currentGameState
    $XOArray = [
        "=============",
        "       +---+---+---+",
        "       | {$XOdataArray[0]} | {$XOdataArray[1]} | {$XOdataArray[2]} |",
        "       +---+---+---+",
        "       | {$XOdataArray[3]} | {$XOdataArray[4]} | {$XOdataArray[5]} |",
        "       +---+---+---+",
        "       | {$XOdataArray[6]} | {$XOdataArray[7]} | {$XOdataArray[8]} |",
        "       +---+---+---+",
        "============="
    ];
    foreach ($XOArray as $value) {
        line($value);
    }
}

function getPositionFromInput(): int
{
    $minUserNum = 0;
    $maxUserNum = 9;
    $userNum = prompt("choice num 1-9 ");
    while ($userNum <= $minUserNum || $userNum > $maxUserNum) {
        $userNum = prompt("Please read only 1-9 ");
    }
    return --$userNum;
}
