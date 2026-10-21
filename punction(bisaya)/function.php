<?php


function calculate($num1, $num2, $op) {
    switch($op){
        case 'sum':
            return $num1 + $num2;
        case 'subtract':
            return $num1 - $num2;
        case 'multiply':
            return $num1 * $num2;
        case 'divide':
            return $num1 / $num2;
        default:
            return "Invalid operation selected.";
    }
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    calculate($_POST['num1'], $_POST['num2'], $_POST['op']);
}   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="num1">
        <br><br>
        <input type="text" name="num2">
        <br><br>
        <select name="op" id="">
            <option value="sum">Add</option>
            <option value="subtract">Subtract</option>
            <option value="multiply">Multiply</option>
            <option value="divide">Divide</option>
        </select>
        <button type="submit">Calculate</button>
    </form>

</body>
</html>
