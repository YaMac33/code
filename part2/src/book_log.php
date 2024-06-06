<?php

function validate($review)
{
    $errors = [];

	if (!mb_strlen($review['title'])){
		$errors['title'] = '書籍名を入力してください';
	} elseif (mb_strlen($review['title']) > 255) {
		$errors['title'] = '書籍名は255文字以内で入力してください';
	}

    if (!mb_strlen($review['author'])){
		$errors['author'] = '著者名を入力してください';
	} elseif (mb_strlen($review['author']) > 100) {
		$errors['author'] = '著者名は100文字以内で入力してください';
	}

    if (!mb_strlen($review['status'])){
		$errors['status'] = '「未読」「読んでる」「読了」から選んでください';
	} elseif (mb_strlen($review['status']) > 10) {
		$errors['status'] = '読書状況は10文字以内で入力してください';
	}

    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '評価は1～5の整数を入力してください';
    }

    if (!mb_strlen($review['summary'])){
		$errors['summary'] = '感想を入力してください';
	} elseif (mb_strlen($review['summary']) > 1000) {
		$errors['summary'] = '感想は1000文字以内で入力してください';
	}

	return $errors;
}

function listReviews($link)
{
    echo '登録されている読書ログを表示します' . PHP_EOL;

    $sql = 'SELECT id, title, author, status, score, summary FROM reviews';
    $results = mysqli_query($link, $sql);

    while ($review = mysqli_fetch_assoc($results)) {
        echo '書籍名：' . $review['title'] . PHP_EOL;
        echo '著者名：' . $review['author'] . PHP_EOL;
        echo '読書状況：' . $review['status'] . PHP_EOL;
        echo '評価：' . $review['score'] . PHP_EOL;
        echo '感想：' . $review['summary'] . PHP_EOL;
        echo '-------------' . PHP_EOL;
    }

    mysqli_free_result($results);
}

function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    } // echo 'データベースと接続しました' . PHP_EOL;
    return $link;
}

function createReview($link)
{
    $review = [];

    echo '読書ログを登録してください' . PHP_EOL;
    echo '書籍名：';
    $review['title'] = trim(fgets(STDIN));

    echo '著者名：';
    $review['author'] = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）：';
    $review['status'] = trim(fgets(STDIN));

    echo '評価（5点満点の整数）：';
    $review['score'] = trim(fgets(STDIN));

    echo '感想：';
    $review['summary'] = trim(fgets(STDIN));

        $validated = validate($review);
        if (count($validated) > 0) {
            foreach ($validated as $error) {
                echo $error . PHP_EOL;
            }
            return;
        }

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
EOT;

$result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging Error: ' . mysqli_error($link) . PHP_EOL . PHP_EOL;
    }
}

$link = dbConnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）：';
    $num = trim(fgets(STDIN));
    if ($num === trim(1)) {
        createReview($link);
    } elseif ($num === trim(2)) {
        listReviews($link);
    } elseif ($num === trim(9)) {
        echo 'アプリケーションを終了します';
        mysqli_close($link);
        break;
    }
}
