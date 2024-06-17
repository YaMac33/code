<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function listviewTimes($link)
{
    $viewTimes = [];
    $sql = 'SELECT channelName, channelNumber, viewingTime FROM viewTimes;';
    $results = mysqli_query($link, $sql);
    while ($viewTime = mysqli_fetch_assoc($results)) {
        $viewTimes[] = $viewTime;
    }
    mysqli_free_result($results);
    return $viewTimes;
}

$link = dbConnect();
$viewTimes = listviewTimes($link);

$title = 'テレビ視聴情報の一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';