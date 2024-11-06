<?php
$arr = array($_POST["user"],$_POST["pass"]);
$dsn = "mysql:dbname=sinadasi;host=localhost";
$my = new PDO($dsn, "sina", "sina");
$sql = "SELECT * FROM ログイン管理;";
$st = $my -> prepare($sql);
if($st->execute($arr) == false)
    echo("データの追加に失敗しました");
else
    echo("データを追加しました");
    header('Location:kirok.html');
?>
