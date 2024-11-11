<?php
if (isset($_POST["name"], $_POST["kengen"],$_POST["user"])) {
    $a = $_POST["name"];  // ユーザー名
    $password = $_POST["kengen"];  // パスワード
    $user = $_POST["user"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";

    $my = new PDO($dsn, "sina", "sina");
    // SQL文（パスワードを取得）
    $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :user";
    // SQL準備
    $st = $my->prepare($sql);
    $st->bindParam(':user', $a, PDO::PARAM_STR);
    $st->execute();

    // 結果を取得
    $result = $st->fetch(PDO::FETCH_ASSOC);