<h1 class="h2 text-dark mt-4 mb-4">テレビ視聴情報の登録</h1>
<form action="create.php" method="POST">
    <?php if(count($errors)) : ?>
        <ul class="text-danger">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="form-group">
        <label for="channelName">チャンネル名</label>
        <input type="text" id="channelName" name="channelName" class="form-control mb-4" value="<?php echo $viewTime['channelName'] ?>">
    </div>
    <div class="form-group">
        <label for="establishment_date">視聴日</label>
        <input type="date" id="establishment_date" name="establishment_date" class="form-control mb-4" value="<?php echo $viewTime['establishment_date'] ?>">
    </div>
    <div class="form-group">
        <label for="founder">視聴者</label>
        <input type="text" id="founder" name="founder" class="form-control mb-4" value="<?php echo $viewTime['founder'] ?>">
    </div>
    <div>
        <button type="submit" class="btn btn-primary">登録する</button>
    </div>
</form>
</div>