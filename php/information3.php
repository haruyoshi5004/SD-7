<?php
if (isset($_POST["user"], $_POST["pass"])) {
    $a = $_POST["user"];  // ユーザー名
    $password = $_POST["pass"];  // パスワード
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $my = new PDO($dsn, "sina", "sina");
    
    // SQL文（パスワードを取得）
    $sql = "INSERT INTO ログイン管理(user, pass) VALUES (:user, :pass)";
    
    // SQL準備
    $st = $my->prepare($sql);
    $params = array(':user' => $a, ':pass' => $password);
    
    if ($st->execute($params)) {
        echo "挿入に成功しました！";
    } else {
        echo "挿入に失敗しました！";
    }
}
?>
