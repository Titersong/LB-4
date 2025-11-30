<?php
$historyFile = "history.txt";
$result = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {

    $num1 = floatval($_POST["num1"]);
    $num2 = floatval($_POST["num2"]);
    $op = $_POST["operation"];

    switch ($op) {
        case "+": $result = $num1 + $num2; break;
        case "-": $result = $num1 - $num2; break;
        case "*": $result = $num1 * $num2; break;
        case "/":
            $result = ($num2 == 0) ? "Помилка: поділ на нуль" : $num1 / $num2;
            break;
    }

    file_put_contents($historyFile, date("Y-m-d H:i:s") . " — $num1 $op $num2 = $result\n", FILE_APPEND);
}

$history = file_exists($historyFile) ? file_get_contents($historyFile) : "";
?>


<!DOCTYPE html>
<html lang="ua">
<head>
<meta charset="UTF-8">
<title>Калькулятор</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="calc-box">
    <b>Калькулятор</b><br><br>

    <form method="POST" style="display:flex; align-items:center; gap:10px;">
        <input type="text" name="num1" value="0">

        <span class="operator">
            <label><input type="radio" name="operation" value="+"> +</label> <br>
            <label><input type="radio" name="operation" value="-" checked> -</label> <br>
            <label><input type="radio" name="operation" value="/"> /</label> <br>
            <label><input type="radio" name="operation" value="*"> *</label> <br>
        </span>

        <input type="text" name="num2" value="0">

        <button type="submit" name="submit">Обчислити</button>
    </form>

    <?php if ($result !== ""): ?>
        <p><b>Результат: </b><?php echo $result; ?></p>
    <?php endif; ?>
</div>

<div class="history-box">
    <b>Історія обчислень:</b><br><br>
    <?= $history ?: "Історія порожня." ?>
</div>

</body>
</html>
