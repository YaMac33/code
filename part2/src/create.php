<?php

require_once __DIR__ . '/lib/mysqli.php';

function createReview($link, $review)
{
    $sql = <<<EOT
INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
)
EOT;$result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging Error: ' . mysqli_error($link));
    }
}

// 追記
function validate($review)
{
    $errors = [];

    // 書籍名が正しく入力されているかチェック
    if (!strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名が正しく入力されているかチェック
    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($review['author']) > 255) {
        $errors['author'] = '著者名は255文字以内で入力してください';
    }

    // 読書状況が正しく入力されているかチェック
    if (!in_array($review['status'], ['未読', '読んでる', '読了'])) {
        $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを入力してください';
    }

    // 評価が正しく入力されているかチェック
    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1〜5の整数を入力してください';
    }

    // 感想が正しく入力されているかチェック
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (strlen($review['summary']) > 10000) {
        $errors['summary'] = '感想は10,000文字以内で入力してください';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
     * status（読書状況）が未入力のときに $_POST['status'] を呼び出すとエラーになるためその対策として処理を入れている
     * エラーになる理由は、ラジオボタンがチェックされていないとデータが送信されず、$_POST 内に status というキーが存在しないにも関わらず status キーにアクセスしようとするから
     * status が未入力のときにエラーにならないのであれば他の対処方法でも良い（読書状況のラジオボタンにデフォルトでチェックを入れておくなど）
     */
    $status = '';
    if (array_key_exists('status', $_POST)) {
        $status = $_POST['status'];
    }

    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $status,
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    // バリデーション処理を追加
    $errors = validate($review);

    if (!count($errors)) {
        $link = dbConnect();
        createReview($link, $review);
        mysqli_close($link);
        header("Location: index.php");
    }
}

$title = '読書ログ登録';
// ここを修正
$content = __DIR__ . "/views/new.php";
include __DIR__ . '/views/layout.php';
