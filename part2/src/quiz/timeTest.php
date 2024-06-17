<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>時間変換</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            margin-bottom: 10px;
        }
        .result {
            font-size: 1.2em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="">
            <label for="minutesInput">分数を入力してください:</label>
            <input type="number" name="minutes" id="minutesInput" placeholder="例: 70">
            <button type="submit">計算</button>
        </form>
    </div>
    <div class="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $minutes = intval($_POST["minutes"]);
            if ($minutes < 0) {
                echo "正の整数を入力してください。";
            } else {
                $hours = floor($minutes / 60);
                $remainingMinutes = $minutes % 60;
                $result = $hours . ":" . str_pad($remainingMinutes, 2, "0", STR_PAD_LEFT);
                echo "結果: " . htmlspecialchars($result);
            }
        }

        include __DIR__ . '/views/layout.php';
        ?>
    </div>
</body>

