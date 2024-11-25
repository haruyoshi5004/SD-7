<?php
if (isset($_POST["name"], $_POST["kengen"], $_POST["user"])) {
    $a = $_POST["name"];  
    $ken = $_POST["kengen"];  
    $user = $_POST["user"]; 
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :user";
        $st = $my->prepare($sql);
        $st->bindParam(':user', $user, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $admin_id = $result['管理者id'];
            $sql = "INSERT INTO ユーザー名(管理者id, 名前, 管理者権限) VALUES (:id, :name, :ken)";
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
