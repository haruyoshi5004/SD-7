<?php
if (isset($_POST["user"])) {
    try {
        $username = $_POST["user"];
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        $my = new PDO($dsn, "sina", "sina");
        $sql = "SELECT 管理者ID FROM ユーザー名 WHERE 名前 = :user";
        $st = $my->prepare($sql);
        $st->bindParam(':user', $username, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $adomin_id = $result["管理者ID"];
            $sql = "DELETE FROM ログイン管理 WHERE 名前 = :user";
            $st = $my->prepare($sql);
            $st->bindParam(':user', $username, PDO::PARAM_STR);
            $st->execute();
            $sql = "DELETE FROM ユーザー名 WHERE 管理者ID = :admin_id";
            $st = $my->prepare($sql);
            $st->bindParam(':admin_id', $adomin_id, PDO::PARAM_INT);
            $st->execute();
        } else {
            echo "ユーザーが見つかりません。";
        }
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>
