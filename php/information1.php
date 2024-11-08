<?php
// ユーザー名とパスワードがPOSTされた場合
if (isset($_POST["user"], $_POST["pass"])) {
    $a = $_POST["user"];  // ユーザー名
    $password = $_POST["pass"];  // パスワード
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $my = new PDO($dsn, "sina", "sina");
    // SQL文（パスワードを取得）
    $sql = "SELECT パスワード FROM ログイン管理 WHERE ユーザー名 = :user";
    // SQL準備
    $st = $my->prepare($sql);
    $st->bindParam(':user', $a, PDO::PARAM_STR);
    $st->execute();

    // 結果を取得
    $result = $st->fetch(PDO::FETCH_ASSOC);

    // パスワードが一致するか確認
    if ($result && $result['パスワード'] === $password) {
        // ログイン成功
        header("Location: information2.html");
        exit();  // headerの後にexitを追加して、リダイレクト後のコードが実行されないようにする
    } else {
        // ログイン失敗
        echo "<script type='text/javascript'>
            alert('ユーザー名またはパスワードが間違っています。');
            window.location.href = '情報登録1.html';
        </script>";
        exit();
    }
}
?>
