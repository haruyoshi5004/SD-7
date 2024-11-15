<?php
if (isset($_POST["name"],$_POST["pass"] $_POST["kengen"], $_POST["user"])) {
    $a = $_POST["name"];  // ユーザー名
    $pass = $_POST["pass"];
    $ken = $_POST["kengen"];  // 管理者権限
    $user = $_POST["user"];  // ここでは使っていない変数（後で使用しないなら削除可能）

    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        // SQL文（管理者idを取得）
        $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :user";
        // SQL準備
        $st = $my->prepare($sql);
        $st->bindParam(':user', $user, PDO::PARAM_STR);
        $st->execute();
        // 結果を取得
        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // 管理者idを取り出す
            $admin_id = $result['管理者id'];

            // SQL文（ユーザー情報の挿入）
            $sql = "INSERT INTO ユーザー名(管理者id, 名前, 管理者権限) VALUES (:id, :name, :ken)";
            // SQL準備
            $st = $my->prepare($sql);
            $params = array(':id' => $admin_id, ':name' => $a, ':ken' => $ken);

            if ($st->execute($params)) {
                header("Location:../information/情報登録4.html");
            } else {
                echo "挿入に失敗しました！";
            }
        } else {
            echo "指定されたユーザー名は存在しません。";
        }

    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>
