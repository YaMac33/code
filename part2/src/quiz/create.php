<?php

require_once __DIR__ . '/lib/mysqli.php';

// ４－２　関数の中身を書く
// 引数を２つ($link, $viewTime)指定して、それぞれを
// 変数($sql)に代入する
function createCompany($link, $viewTime)
{
    $sql = <<<EOT
INSERT INTO viewTimes (
    channelName,
    channelNumber,
    founder
) VALUES (
    "{$viewTime['channelName']}",
    "{$viewTime['channelNumber']}",
    "{$viewTime['founder']}"
)
EOT;

    $result = mysqli_query($link, $sql);
    // ４－３　mysqli_queryで$linkの接続が成功(true)で、
    if ($result) {
        // $sqlへの登録に成功(true)なら、「登録が完了しました」
        echo '登録が完了しました' . PHP_EOL;
    } else {
        // $linkの接続が失敗(false)もしくは、
        // $sqlへの登録に失敗(false)なら、「データの追加に失敗しました」と、その理由
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error' . mysqli_error($link) . PHP_EOL;
        error_log('Error: fail to create company');
	    error_log('Debugging Error:　' . mysqli_error($link));
    }
}

function validate($viewTime)
{
    // まず、エラー情報を配列で保存する
    $errors = [];

    // チャンネル名
    if (!strlen($viewTime['channelName'])) {
        $errors['channelName'] = 'チャンネル名を入力してください';
    } elseif (strlen($viewTime['channelName']) > 255) {
        $errors['channelName'] = 'チャンネル名は255文字以内で入力してください';
    }

    // 設立日
    // 2020-10-8 → 2020 10 8 「explode」で一度分離させる
    $dates = explode('-', $viewTime['channelNumber']);
    // 「日付じゃなかったらエラー」を出力するために、まず
    // どんな形式で出力されているか確認する
    // var_dump($viewTime['channelNumber']);
    if (!strlen($viewTime['channelNumber'])) {
        $errors['channelNumber'] = '設立日を入力してください';
    // 月、日、年
    } elseif (count($dates) !== 3) {
        $errors['channelNumber'] = '設立日を正しい形式で入力してください';
    } elseif (!checkDate($dates[1], $dates[2], $dates[0])) {
        $errors['channelNumber'] = '設立日を正しい日付で入力してください';
    }

    // 代表者
    if (!strlen($viewTime['founder'])) {
        $errors['founder'] = '代表者名を入力してください';
    } elseif (strlen($viewTime['founder']) > 100) {
            $errors['founder'] = '代表者名は100文字以内で入力してください';
    }

    return $errors;
}

// １　HTTPメソッドがPOSTだったら、
// (定義済みの変数「$_SERVER」の「REQUEST_METHOD」が「POST」だったら、)
// (「REQUEST_METHOD」が、GETなのかPOSTなのかなどを取得できる)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ２　POSTされた会社情報を変数(連想配列)に格納して、
    // (ここの['○○']は「new.php」でいう「label for」「id」「channelName」のどれに当たる？)→どれでもなかった
    // (var_export($_POST); で格納された値を確認するとよい)
    $viewTime = [
        'channelName' => $_POST['channelName'],
        'channelNumber' => $_POST['channelNumber'],
        'founder' => $_POST['founder']
    ];
    // (var_export($viewTime); で、処理後の状況を確認するのもよい)


    // ６　バリデーションをする
    // companyで受け取った処理に対してエラーを返す
    $errors = validate($viewTime);

    // バリデーションエラーがなければ
    // もしエラーをcountして1もなければ
    if(!count($errors)) {
        $link = dbConnect();
        createCompany($link, $viewTime);
        mysqli_close($link);
        header("Location: index.php");

    // もしエラーがあればフォーム上でHTML内の情報を表示させる必要がある
    // 荒業だが、new.phpの2行目以降をひとまずすべて貼り付ける
    }

    // もしエラーがあればフォーム上でHTML内の情報を表示させる必要がある
    // 荒業だが、new.phpの2行目以降をひとまずすべて貼り付ける
}

$content = __DIR__ . "/views/new.php";
include __DIR__ . '/views/layout.php';