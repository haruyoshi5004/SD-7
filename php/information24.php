<?php
if (isset($_POST["user"], $_POST["pass"],$_POST["page"])) {
    $a = $_POST["user"]; 
    $password = $_POST["pass"];
    $page = $_POST["page"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $my = new PDO($dsn, "sina", "sina");
    $sql = "SELECT パスワード FROM ログイン管理 WHERE ユーザー名 = :user";
    $st = $my->prepare($sql);
    $st->bindParam(':user', $a, PDO::PARAM_STR);
    $st->execute();
    $result = $st->fetch(PDO::FETCH_ASSOC);
    if ($result && password_verify($password, $result['パスワード'])) {
        $sql = "SELECT 管理者ID FROM ログイン管理 WHERE ユーザー名 = :user";
        $st = $my->prepare($sql);
        $st->bindParam(':user', $a, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $b = $result["管理者ID"];
        $sql = "SELECT 管理者権限 FROM ユーザー名 WHERE 管理者ID = :id";
        $st = $my->prepare($sql);
        $st->bindParam(':id', $b, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $ken = $result["管理者権限"];
        if(!$result){
            echo "<script type='text/javascript'> alert('アカウント情報が入力されていません'); window.location.href = '../information/情報登録24.html'; </script>";
            exit();
        }else{
            if($ken == "all" || $ken == "part"){
                if($page==1){
                    header("Location: ../information/情報登録3.html");
                    exit();
                }elseif($page==2){
                    header("Location: ../information/情報登録22.html");
                    exit();
                }elseif($page==4){
                    header("Location: ../information/情報登録17.html");
                    exit(); 
                }   
            }else{
                echo "<script type='text/javascript'> alert('権限が与えられていません'); window.location.href = '../information/情報登録24.html'; </script>";
                exit();
            }
            exit();
        }
    } else {
        echo "<script type='text/javascript'>
            alert('ユーザー名またはパスワードが間違っています。');
            window.location.href = '../information/情報登録24.html';
        </script>";
        exit();
    }
}
?>
