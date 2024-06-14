<?php

// javascriptなどを読み込んで実行してしまう脆弱性の回避のコード
require_once __DIR__ . '/lib/escape.php';
// create.phpからコピペ(lib/mysqli.phpの接続情報)
require_once __DIR__ . '/lib/mysqli.php';

function listCompanies($link)
{
    // ループの外で$companiesを空配列として定義しておく
    $companies = [];
    // sqlで取得したいテーブルとその中のデータを指定する
    $sql = 'SELECT name, establishment_date, founder FROM companies;';
    $results = mysqli_query($link, $sql);

    while ($company = mysqli_fetch_assoc($results)) {
        $companies[] = $company;
    }

    // 変数を解放する
    mysqli_free_result($results);

    return $companies;
}

// データに接続
$link = dbConnect();
// 会社情報を取得してきて、$companies変数に入れる
$companies = listCompanies($link);

$title = '会社情報の一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';