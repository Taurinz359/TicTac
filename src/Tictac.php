<?php

namespace Game;

use function cli\input;
use function cli\line;
use function cli\out;
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
        " "," "," ",
        " "," "," ",
        " "," "," "
    ];
    $i = 0;
    while ($i < 9) {
        if ($i % 2 === 0) {
            line("\nMove X: ");
        } else {
            line("\nMove O: ");
        }
        $position = readnCheckSymbol();
        --$position;
        if ($currentGameState[$position ] !== " ") {
            line("This position is busy, Try again!");
            continue;
        }
        system('clear');

        if ($i % 2 === 0) {
            $currentGameState[$position] = "X";
        } else {
            $currentGameState[$position] = "O";
        }
        showCurrentGameStateTable($currentGameState);
        if (3 < $i) {
            $winner = checkWinner($currentGameState);
            if ($winner != "null"){
                line($winner);
                exit;
            }
        }
        ++$i;
    }
    line("oOps it is Draw! :c ");
}

function checkWinner(array $currentGameState):string
{   
    $winPosition = [
        [0,1,2],
        [0,3,6],
        [0,4,8],
        [1,4,7],
        [2,5,8],
        [2,4,6],
        [3,4,5],
        [6,7,8]
    ];
    $xOccurs = 0;
    $oOccurs = 0;

    for ($i=0; $i < count($winPosition); $i++) { 
        for ($j=0; $j < count($winPosition[$i]); $j++) { 
            if($currentGameState[$winPosition[$i][$j]] === "X"){ 
                ++$xOccurs;
            }
            elseif($currentGameState[$winPosition[$i][$j]] === "O"){
                ++$oOccurs;
            }
        }
        if($xOccurs === 3){
            return "X the Winner";
        }
        else{
            $xOccurs=0;
        }
        if($oOccurs === 3){
            return "O the Winner!";
        }
        else{
            $oOccurs=0;
        }
    }
    return "null";
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
{
//this function drawing currentGameState
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

function readnCheckSymbol() : int
{
    $userNum = prompt("choice num 1-9 ");
    while ($userNum <= 0 || $userNum > 9) {        
        $userNum = prompt ("Please read only 1-9 ");
    }
    return $userNum;
}
