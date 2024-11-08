<?php
if(isset($_POST['user'],$_POST['pass'])){
$a = $_POST["user"];
$arr = array($_POST["pass"]);
$dsn = "mysql:dbname=sinadasi;host=localhost";
$my = new PDO($dsn, "sina", "sina");
$sql = "SELECT パスワード WHERE ユーザー名 = a FROM ログイン管理;";
$st = $my -> query($sql);
if($st == $a){
    header("Location:information2.html");
}else{
    $alert = "<script type='text/javascript'>alert('これはalertです。');</script>";
    echo $alert;
    header('Location:information1.php');
}
}
?>
