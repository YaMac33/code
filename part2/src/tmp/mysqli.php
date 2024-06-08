echo 'データベースに接続できました' . PHP_EOL;

// ここにこれを追加する
// 複数行で書くのも可
$sql = 'SELECT name, founder FROM companies';
// $linkと$sqlを引数に取る
$results = mysql_query($link, $sql);

// 結果を取得する
// $companyは初登場。変数に入れておくために設定。
while ($company = mysqli_fetch_assoc($results)) {
	var_export($company);
}

// $sql = <<<EOT