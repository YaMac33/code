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
EOT;

    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging Error: ' . mysqli_error($link));
    }
}

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
		$errors['status'] = '読書状況は「未読」「読んでる」「読了」から選んでください';
	} elseif (mb_strlen($review['status']) > 10) {
		$errors['status'] = '読書状況は「未読」「読んでる」「読了」から選んでください';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $_POST['status'],
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    $errors = validate($review);

    if(!count($errors)) {
        $link = dbConnect();
        createReview($link, $review);
        mysqli_close($link);
        header("Location: index.php");
    }
}

include 'views/new.php';