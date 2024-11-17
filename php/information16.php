<?php
if (isset($_POST["user"], $_POST["name"], $_POST["pass"], $_POST["kengen"])) {
    $a = $_POST["name"];  // ユーザー名
    $pass = $_POST["pass"];
    $ken = $_POST["kengen"];
    $user = $_POST["user"];

    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL文（管理者idを取得）
        $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :username";
        $st = $my->prepare($sql);
        $st->bindParam(':username', $user, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $admin_id = $result['管理者id'];
            $sql = "UPDATE ログイン管理 SET ";
            $params = array();

            if (!empty($a)) {
                $sql .= "名前 = :name, ";
                $params[':name'] = $a;
            }

            if (!empty($pass)) {
                // パスワードをハッシュ化して保存
                $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
                $sql .= "パスワード = :pass, ";
                $params[':pass'] = $hashedPassword;
            }

            if (!empty($ken)) {
                $sql .= "管理者権限 = :kengen, ";
                $params[':kengen'] = $ken;
            }

            // 最後のカンマとスペースを削除
            $sql = rtrim($sql, ', ');
            $sql .= " WHERE 管理者id = :id";
            $params[':id'] = $admin_id;

            // SQL準備
            $st = $my->prepare($sql);

            if ($st->execute($params)) {
                header("Location: ../information/情報登録18.html");
                exit();
            } else {
                echo "更新に失敗しました！";
            }
        } else {
            echo "指定されたユーザー名は存在しません。";
        }

    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>
