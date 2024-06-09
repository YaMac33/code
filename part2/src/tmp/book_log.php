<?php

function createReview()
{
    echo '読書ログを登録してください' . PHP_EOL;
    echo '書籍名：';
    $title = trim(fgets(STDIN));

    echo '著者名：';
    $author = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）：';
    $status = trim(fgets(STDIN));

    echo '評価（5点満点の整数）：';
    $score = trim(fgets(STDIN));

    echo '感想：';
    $summary = trim(fgets(STDIN));

    echo '登録が完了しました' . PHP_EOL . PHP_EOL;

    return [
        'title' => $title,
        'author' => $author,
        'status' => $status,
        'score' => $score,
        'summary' => $summary,
    ];
}

/**
 * ここを追加
 *
 * 読書ログを一覧表示するので、listReviews と名付けた
 */
function listReviews($reviews)
{
    echo '登録されている読書ログを表示します' . PHP_EOL;

    foreach ($reviews as $review) {
        echo '書籍名：' . $review['title'] . PHP_EOL;
        echo '著者名：' . $review['author'] . PHP_EOL;
        echo '読書状況：' . $review['status'] . PHP_EOL;
        echo '評価：' . $review['score'] . PHP_EOL;
        echo '感想：' . $review['summary'] . PHP_EOL;
        echo '-------------' . PHP_EOL;
    }
}

$reviews = [];

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）：';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        $reviews[] = createReview();
    } elseif ($num === '2') {
        /**
         * ここを追加
         *
         * 関数を呼び出す
         */
        listReviews($reviews);
    } elseif ($num === '9') {
        break;
    }
}