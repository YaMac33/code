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
                        チャンネル番号：<?php echo escape($viewTime['channelNumber']); ?>&nbsp;|&nbsp;視聴時間：
                        <?php
                            // 視聴時間の計算
                            $hours = floor($viewTime['viewingTime'] / 60); // 時間部分を計算
                            $remainingMinutes = $viewTime['viewingTime'] % 60; // 残りの分数を計算
                            $result = $hours . ":" . str_pad($remainingMinutes, 2, "0", STR_PAD_LEFT); // 時間と分数を適切な形式で結合
                            // 結果の出力
                            echo escape($result);
                        ?>
                    </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>テレビ視聴情報が登録されていません。</p>
    <?php endif; ?>
</main>