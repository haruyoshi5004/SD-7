<?php
if (isset($_POST["username"], $_POST["name"], $_POST["pass"], $_POST["kengen"])) {
    $username = $_POST["username"];  // ユーザー名
    $name = $_POST["name"];
    $password = $_POST["pass"];
    $kengen = $_POST["kengen"];

    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL文（管理者idを取得）
        $sql = "SELECT 管理者id FROM ログイン管理 WHERE ユーザー名 = :username";
        $st = $my->prepare($sql);
        $st->bindParam(':username', $username, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $admin_id = $result['管理者id'];
            $sql = "UPDATE ログイン管理 SET ";
            $params = array();

            if (!empty($name)) {
                $sql .= "名前の列名 = :name, ";  // 名前の列名を正しい列名に変更
                $params[':name'] = $name;
            }

            if (!empty($kengen)) {
                $sql .= "管理者権限の列名 = :kengen, ";  // 管理者権限の列名を正しい列名に変更
                $params[':kengen'] = $kengen;
            }

            // 最後のカンマとスペースを削除
            $sql = rtrim($sql, ', ');
            $sql .= " WHERE 管理者id = :id";
            $params[':id'] = $admin_id;

            // SQL準備
            $st = $my->prepare($sql);

            if ($st->execute($params)) {
                // パスワードが入力されていた場合、別のテーブルにパスワードを更新
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sql_password = "UPDATE ユーザー管理 SET パスワード = :pass WHERE 管理者id = :id";
                    $st_password = $my->prepare($sql_password);
                    $params_password = array(':pass' => $hashedPassword, ':id' => $admin_id);

                    if ($st_password->execute($params_password)) {
                        header("Location: ../information/情報登録4.html");
                        exit();
                    } else {
                        echo "パスワードの更新に失敗しました！";
                    }
                } else {
                    header("Location: ../information/情報登録4.html");
                    exit();
                }
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
