<?php

require_once __DIR__ . '/lib/mysqli.php';

function createCompany($link, $viewTime)
{
    $sql = <<<EOT
INSERT INTO viewTimes (
    channelName,
    channelNumber,
    viewingTime
) VALUES (
    "{$viewTime['channelName']}",
    "{$viewTime['channelNumber']}",
    "{$viewTime['viewingTime']}"
)
EOT;

    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error' . mysqli_error($link) . PHP_EOL;
        error_log('Error: fail to create company');
        error_log('Debugging Error:　' . mysqli_error($link));
    }
}

function validate($viewTime)
{
    $errors = [];

    // チャンネル名
    if (!strlen($viewTime['channelName'])) {
        $errors['channelName'] = 'チャンネル名を入力してください';
    } elseif (strlen($viewTime['channelName']) > 255) {
        $errors['channelName'] = 'チャンネル名は255文字以内で入力してください';
    }

    // チャンネル番号
    if (!strlen($viewTime['channelNumber'])) {
        $errors['channelNumber'] = 'チャンネル番号を入力してください';
    } elseif (strlen($viewTime['channelNumber']) > 255) {
        $errors['channelNumber'] = 'チャンネル番号は255文字以内で入力してください';
    }

    // 視聴時間
    if (!strlen($viewTime['viewingTime'])) {
        $errors['viewingTime'] = '視聴時間を入力してください';
    } elseif (strlen($viewTime['viewingTime']) > 100) {
            $errors['viewingTime'] = '代表者名は100文字以内で入力してください';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $viewTime = [
        'channelName' => $_POST['channelName'],
        'channelNumber' => $_POST['channelNumber'],
        'viewingTime' => $_POST['viewingTime']
    ];

    $errors = validate($viewTime);

    if(!count($errors)) {
        $link = dbConnect();
        createCompany($link, $viewTime);
        mysqli_close($link);
        header("Location: index.php");
    }
}

$content = __DIR__ . "/views/new.php";
include __DIR__ . '/views/layout.php';