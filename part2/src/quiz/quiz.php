<?php

const SPLIT_LENGTH = 2;

function getInput()
{
    $argument = array_slice($_SERVER['argv'], 1);
    return array_chunk($argument, SPLIT_LENGTH);
}

function groupChannelViewingPeriods (array $inputs): array
{
    $channelViewingPeriods = [];
    foreach ($inputs as $input) {
        $chan = $input[0];
        $min = $input[1];
        $mins = [$min];
        if (array_key_exists($chan, $channelViewingPeriods)) {
            $mins = array_merge($channelViewingPeriods[$chan], $mins);
        }
        $channelViewingPeriods[$chan] = $mins;
    }
    return $channelViewingPeriods;
}

function display(array $channelViewingPeriods): void
{
    $totalHour = calculateTotalHour($channelViewingPeriods);
    echo $totalHour . PHP_EOL;
    foreach ($channelViewingPeriods as $chan => $mins) {
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}

function calculateTotalHour(array $channelViewingPeriods):float
{
    $viewingTimes = [];
    foreach ($channelViewingPeriods as $periods) {
        $viewingTimes = array_merge($viewingTimes, $periods);
    }
    $totalMin = array_sum($viewingTimes);

    return round($totalMin / 60, 1);
}

$inputs = getInput();
$channelViewingPeriods = groupChannelViewingPeriods ($inputs);
display($channelViewingPeriods);