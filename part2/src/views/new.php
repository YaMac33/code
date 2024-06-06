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
            <input type="text" id="title" name="title" value="<?php echo $review['title'] ?>">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" id="author" name="author" value="<?php echo $review['author'] ?>">
        </div>
        <div>
            <label for="stasus">読書状況</label>
            <div>
                <input type="radio"name="status"id="status1"value="未読" <?php echo ($review['status'] === '未読') ? 'checked' : ''; ?>>
                <label for="stasus1">未読</label>
                <input type="radio"name="status"id="status2"value="読んでる" <?php echo ($review['status'] === '読んでる') ? 'checked' : ''; ?>>
                <label for="status2">読んでる</label>
                <input type="radio"name="status"id="status3"value="読了" <?php echo ($review['status'] === '読了') ? 'checked' : ''; ?>>
                <label for="status3">読了</label>
            </div>
        </div>
        <div>
            <label for="score">評価(5点満点の整数)</label>
            <input type="text" size="2" id="score" name="score" value="<?php echo $review['score'] ?>">
        </div>
        <div>
            <label for="summary">感想</label>
            <input type="text" size="100" id="summary" name="summary" value="<?php echo $review['summary'] ?>">
        </div>
        <div>
            <button type="submit">登録する</button>
        </div>
    </form>
</body>

</html>