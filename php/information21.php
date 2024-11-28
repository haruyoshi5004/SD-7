<?php
if (isset($_POST["user"], $_POST["pass"])) {
    $a = $_POST["user"];  
    $password = $_POST["pass"];  
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $my = new PDO($dsn, "sina", "sina");
    $sql = "SELECT パスワード FROM ログイン管理 WHERE ユーザー名 = :user";

    $st = $my->prepare($sql);
    $st->bindParam(':user', $a, PDO::PARAM_STR);
    $st->execute();
    $result = $st->fetch(PDO::FETCH_ASSOC);
    if ($result && password_verify($password, $result['パスワード'])) {
        header("Location: ../information/情報登録16.html?user=" . urlencode($a));
        exit(); 
    } else {
        echo "<script type='text/javascript'>
            alert('ユーザー名またはパスワードが間違っています。');
            window.location.href = '../information/情報登録1.html';
        </script>";
        exit();
    }
}
?>
