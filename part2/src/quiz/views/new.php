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
        <label for="channelNumber">視聴日</label>
        <input type="date" id="channelNumber" name="channelNumber" class="form-control mb-4" value="<?php echo $viewTime['channelNumber'] ?>">
    </div>
    <div class="form-group">
        <label for="viewingTime">視聴者</label>
        <input type="text" id="viewingTime" name="viewingTime" class="form-control mb-4" value="<?php echo $viewTime['viewingTime'] ?>">
    </div>
    <div>
        <button type="submit" class="btn btn-primary">登録する</button>
    </div>
</form>
</div>