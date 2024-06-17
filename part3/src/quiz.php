<?php

// 分離するLENGTH数を2としたいので、定義づける。
const SPLIT_LENGTH = 2;

// データを取得する関数
function getInput()
{
    // $_serverは「サーバーや実行時の環境情報」
    // 連想配列として受け取る
    // REQUEST_METHOD:ページにアクセスする際に使用されたリクエストのメソッド名。'GET','POST'など。
    $argument = array_slice($_SERVER['argv'], 1);

    // 指定した数ずつ配列を組みなおす
    // [[1, 30], [5, 25]]
    return array_chunk($argument, SPLIT_LENGTH);
}

// ()内で型と引数を指定し、その外(右側)で戻り値の型を指定している。
// (配列 引数) 戻り値:配列
function groupChannelViewingPeriods (array $inputs): array
{
    // まず空配列を定義して、
    $channelViewingPeriods = [];
    // $inputs配列内の各要素にアクセスする繰り返し処理のコードを書いて、
    foreach ($inputs as $input) {
        // チャンネルは1列目、
        $chan = $input[0];
        // 分数は2列目。
        $min = $input[1];
        // 分数を集約した配列$minsを、$minを引数として作成する。
        $mins = [$min];
        // ↓ array_key_existsは「指定したkeyが含まれているかを(複数回か否かということを含めて)確認する」メソッド。
        // もし$chanというkeyが配列$channelViewingPeriodsに含まれていれば、
        if (array_key_exists($chan, $channelViewingPeriods)) {
            // 配列$channelViewingPeriodsの同じ$chanの$minsにマージ合体させてね。という指示。
            $mins = array_merge($channelViewingPeriods[$chan], $mins);
        }
        // 配列$channelViewingPeriods内の$chanに、
        // 各分数$minを集約した$minsを入れる
        $channelViewingPeriods[$chan] = $mins;
    }
    // それらの値を変数$channelViewingPeriodsに返す
    return $channelViewingPeriods;
}

function calculateTotalHour(array $channelViewingPeriods):float
{
    // 配列$viewingTimesを定義して、
    $viewingTimes = [];
    // 配列$channelViewingPeriodsの中の要素を$periodsとし、foreachで繰り返し処理をする。
    foreach ($channelViewingPeriods as $periods) {
        // それで抽出した$periodsを配列$viewingTimesにマージ合体させる。
        $viewingTimes = array_merge($viewingTimes, $periods);
    }
    // マージ合体した配列$viewingTimesをarray_sumで合計して、変数$totalMinに代入する。
    $totalMin = array_sum($viewingTimes);

    // ↓ この1行で配列の展開とマージができるため、上5行に代えることができるらしい
    // $totalMin = array_sum(array_merge(...$channelViewingPeriods));

    // 以下で分数を時間数に変換する。(小数点第１位までで切り捨て)
    return round($totalMin / 60, 1);
}

// $channelViewingPeriodsをarrayで配列として受け取る
// 表示するだけで、値は何も返さないのでvoidを指定する。
function display(array $channelViewingPeriods): void
{
    // 変数$totalHourには、引数$channelViewingPeriodsを使用した、
    // 関数calculateTotalHourで取得した値を代入する。
    $totalHour = calculateTotalHour($channelViewingPeriods);
    // 変数$totalHour(合計時間)を表示する。
    echo $totalHour . PHP_EOL;
    // foreachで繰り返し表示する。何を？
    foreach ($channelViewingPeriods as $chan => $mins) {
        // →$chan(チャンネル)と、関数array_sumで取得した($mins)(その配列の合計時間)と、
        // 関数countで取得した($mins)(登場回数)を表示する。
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}

// $inputsは関数getInputから取得してきたデータで、
$inputs = getInput();
// その取得したデータを使った関数groupChannelViewingPeriodsから
// 出力したデータが、変数$channelViewingPeriodsに入る。
$channelViewingPeriods = groupChannelViewingPeriods($inputs);
// 関数displayを定義する。
display($channelViewingPeriods);