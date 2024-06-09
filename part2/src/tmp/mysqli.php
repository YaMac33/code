echo 'データベースに接続できました' . PHP_EOL;

$sql = 'SELECT name, founder FROM companies';

$results = mysql_query($link, $sql);

while ($company = mysqli_fetch_assoc($results)) {
	var_export($company);
}

$sql = <<<EOT