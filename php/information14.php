<?php
if (isset($_POST["name"], $_POST["kengen"],$_POST["user"])) {
    $a = $_POST["name"];  // ユーザー名
    $ken = $_POST["kengen"];  // パスワード
    $user = $_POST["user"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try{
        $my = new PDO($dsn, "sina", "sina");
        // SQL文（パスワードを取得）
        $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :user";
        // SQL準備
        $st = $my->prepare($sql);
        $st->bindParam(':user', $a, PDO::PARAM_STR);
        $st->execute();
        // 結果を取得
        $result = $st->fetch(PDO::FETCH_ASSOC);

        // SQL文（パスワードを取得）
        $sql = "INSERT INTO ユーザー名(管理者id,名前,管理者権限) VALUES (:id,:user,:ken)";
        
        // SQL準備
        $st = $my->prepare($sql);
        $params = array(':id' => $result, ':user' => $name,":ken" => $ken);

        if ($st->execute($params)) {
            echo "挿入に成功しました！";
        } else {
            echo "挿入に失敗しました！";
        }

    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>