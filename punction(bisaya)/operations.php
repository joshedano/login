<?php

function calculate($num1, $num2, $op) {
    switch($op){
        case 'sum':
            return sum($num1, $num2);
        case 'subtract':
            return subtract($num1, $num2);
        case 'multiply':
            return multiply($num1, $num2);
        case 'divide':
            return divide($num1, $num2);
        default:
            return "Invalid operation selected.";
    }
}
function sum($num1, $num2){
    return $num1 + $num2;
}

function subtract($num1, $num2){
    return $num1 - $num2;
}

function multiply($num1, $num2){
    return $num1 * $num2;
}

function divide($num1, $num2){
    if ($num2 != 0) {
        return $num1 / $num2;
    } else {
        return "Error: Division by zero is not allowed.";
    }
}
?>