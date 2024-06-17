<?php

// javascriptなどを読み込んで実行してしまう脆弱性の回避のコード
require_once __DIR__ . '/lib/escape.php';
// create.phpからコピペ(lib/mysqli.phpの接続情報)
require_once __DIR__ . '/lib/mysqli.php';

function listviewTimes($link)
{
    // ループの外で$viewTimesを空配列として定義しておく
    $viewTimes = [];
    // sqlで取得したいテーブルとその中のデータを指定する
    $sql = 'SELECT name, establishment_date, founder FROM viewTimes;';
    $results = mysqli_query($link, $sql);

    while ($viewTime = mysqli_fetch_assoc($results)) {
        $viewTimes[] = $viewTime;
    }

    // 変数を解放する
    mysqli_free_result($results);

    return $viewTimes;
}

// データに接続
$link = dbConnect();
// 会社情報を取得してきて、$viewTimes変数に入れる
$viewTimes = listviewTimes($link);

$title = 'テレビ視聴情報の一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';