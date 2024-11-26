<?php
if (isset($_POST["user"], $_POST["pass"])) {
    $a = $_POST["user"];
    $password = $_POST["pass"];  
    $dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO ログイン管理(ユーザー名, パスワード) VALUES (:user, :pass)";
        $st = $my->prepare($sql);
        $params = array(':user' => $a, ':pass' => $hashedPassword);
        if ($st->execute($params)) {
            header("Location:../information/情報登録20.html");
            echo "挿入に成功しました！";
        } else {
            echo "挿入に失敗しました！";
        }
    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>
