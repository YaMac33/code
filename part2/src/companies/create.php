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
        error_log('Error: fail to create company');
	    error_log('Debugging Error:　' . mysqli_error($link));
    }
}

function validate($company)
{
    // まず、エラー情報を配列で保存する
    $errors = [];

    // 会社名
    if (!strlen($company['name'])) {
        $errors['name'] = '会社名を入力してください';
    } elseif (strlen($company['name']) > 255) {
        $errors['name'] = '会社名は255文字以内で入力してください';
    }

    // 設立日
    // 2020-10-8 → 2020 10 8 「explode」で一度分離させる
    $dates = explode('-', $company['establishment_date']);
    // 「日付じゃなかったらエラー」を出力するために、まず
    // どんな形式で出力されているか確認する
    var_dump($company['establishment_date']);
    if (!strlen($company['establishment_date'])) {
        $errors['establishment_date'] = '設立日を入力してください';
    // 月、日、年
    } elseif (count($dates) !== 3) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    } elseif (!checkDate($dates[1], $dates[2], $dates[0])) {
        $errors['establishment_date'] = '設立日を正しい日付で入力してください';
    }

    // 代表者
    if (!strlen($company['founder'])) {
        $errors['founder'] = '代表者名を入力してください';
    } elseif (strlen($company['founder']) > 100) {
            $errors['founder'] = '代表者名は100文字以内で入力してください';
    }

    return $errors;
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


    // ６　バリデーションをする
    // companyで受け取った処理に対してエラーを返す
    $errors = validate($company);

    // バリデーションエラーがなければ
    // もしエラーをcountして1もなければ
    if(!count(errors)) {
    $link = dbConnect();
    createCompany($link, $company);
    mysqli_close($link);
    header("Location: index.php");

    // もしエラーがあればフォーム上でHTML内の情報を表示させる必要がある
    // 荒業だが、new.phpの2行目以降をひとまずすべて貼り付ける
}

    // もしエラーがあればフォーム上でHTML内の情報を表示させる必要がある
    // 荒業だが、new.phpの2行目以降をひとまずすべて貼り付ける
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会社情報の登録</title>
</head>

<body>
    <h1>会社情報の登録</h1>
    <!-「action="○○"で、指定したファイルに処理を転送する」ということになる->
    <form action="create.php" method="POST">
    <!- HTMLの中にPHPを埋め込むこともできる ->
    <!- 埋め込みでif文などを書く際は、{}の代わりに:と;を使用する ->
    <!- :が開始、;が終了->
        <?php if (count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div>
            <label for="name">会社名</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="establishment_date">設立日</label>
            <input type="date" id="establishment_date" name="establishment_date">
        </div>
        <div>
            <label for="founder">代表者</label>
            <input type="text" id="founder" name="founder">
        </div>
        <div>
            <button type="submit">登録する</button>
        </div>
    </form>
</body>

</html>
<!-- 
    // ３　データベースに接続して、
    $link = dbConnect();
    // ４－１　データベースにデータを登録して、（先に処理を書いて、）
    createCompany($link, $company);
    // ５　データベースとの接続を切断する
    mysqli_close($link);
}

header("Location: index.php"); -->
