<?php
if (isset($_POST["user"], $_POST["pass"])) {
    $a = $_POST["user"];  // ユーザー名
    $password = $_POST["pass"];  // パスワード
    $dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        // PDO接続
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // パスワードをハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL文（パスワードを取得）
        $sql = "INSERT INTO ログイン管理(ユーザー名, パスワード) VALUES (:user, :pass)";
        
        // SQL準備
        $st = $my->prepare($sql);
        $params = array(':user' => $a, ':pass' => $hashedPassword);

        if ($st->execute($params)) {
            header("Location:../information/情報登録14.html");
            echo "挿入に成功しました！";
        } else {
            echo "挿入に失敗しました！";
        }

    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>
