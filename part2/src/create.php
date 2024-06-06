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
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログ</title>
</head>

<body>
    <h1>読書ログ</h1>
    <form action="create.php" method="POST">
        <?php if(count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div>
            <label for="title">書籍名</label>
            <input type="text" id="title" name="title">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" id="author" name="author">
        </div>
        <div>
            <label for="stasus">読書状況</label>
            <div>
                <input type="radio"name="status"id="status1"value="未読">
                <label for="stasus1">未読</label>
                <input type="radio"name="status"id="status2"value="読んでる">
                <label for="status2">読んでる</label>
                <input type="radio"name="status"id="status3"value="読了">
                <label for="status3">読了</label>
            </div>
        </div>
        <div>
            <label for="score">評価(5点満点の整数)</label>
            <input type="text" size="2" id="score" name="score">
        </div>
        <div>
            <label for="summary">感想</label>
            <input type="text" size="100" id="summary" name="summary">
        </div>
        <div>
            <button type="submit">登録する</button>
        </div>
    </form>
</body>

</html>

