<?php

require_once __DIR__ . '/lib/mysqli.php';

// ４－２　関数の中身を書く
// 引数を２つ($link, $company)指定して、それぞれを
// 変数($sql)に代入する
function createCompany($link, $company)
{
    $sql = <<<EOT
INSERT INTO companies (
    name,
    establishment_date,
    founder
) VALUES (
    "{$company['name']}",
    "{$company['establishment_date']}",
    "{$company['founder']}"
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
    }
}

// １　HTTPメソッドがPOSTだったら、
// (定義済みの変数「$_SERVER」の「REQUEST_METHOD」が「POST」だったら、)
// (「REQUEST_METHOD」が、GETなのかPOSTなのかなどを取得できる)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ２　POSTされた会社情報を変数(連想配列)に格納して、
    // (ここの['○○']は「new.php」でいう「label for」「id」「name」のどれに当たる？)→どれでもなかった
    // (var_export($_POST); で格納された値を確認するとよい)
    $company = [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder']
    ];
    // (var_export($company); で、処理後の状況を確認するのもよい)


    // ６　バリデーション処理を書く予定

    // ３　データベースに接続して、
    $link = dbConnect();
    // ４－１　データベースにデータを登録して、（先に処理を書いて、）
    createCompany($link, $company);
    // ５　データベースとの接続を切断する
    mysqli_close($link);
}

header("Location: index.php");
