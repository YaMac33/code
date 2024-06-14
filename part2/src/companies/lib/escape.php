<?php

// 文字列に変換したい場合のコード
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}