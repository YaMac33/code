<h1 class="h2 text-dark mt-4 mb-4">テレビ視聴情報の一覧</h1>
<a href="new.php" class="btn btn-primary mb-4">テレビ視聴情報を登録する</a>
<main>
    <?php if (count($viewTimes) > 0) : ?>
        <?php foreach ($viewTimes as $viewTime) : ?>
            <section class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-3">
                        <?php echo escape($viewTime['channelName']); ?>
                    </h2>
                    <div>
                        チャンネル：<?php echo escape($viewTime['establishment_date']); ?>&nbsp;|&nbsp;視聴時間：<?php echo escape($viewTime['founder']); ?>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>テレビ視聴情報が登録されていません。</p>
    <?php endif; ?>
</main>