<?php
session_start();
if (isset($_POST["syo"], $_POST["maker"], $_POST["price"], $_POST["info"])) {
    try {
        $syo = $_POST["syo"];
        $maker = $_POST["maker"];
        $price = $_POST["price"];
        $jan = $_POST["Jan"];
        $info = $_POST["info"];
        
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        $my = new PDO($dsn, "sina", "sina");

        $sql = "INSERT INTO 商品(商品名,メーカー,価格,Janコード,商品説明) VALUES (:syo, :maker, :price, :Jan, :info)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $syo, ':maker' => $maker, ':price' => $price, ':Jan' => $jan, ':info' => $info);
        
        if ($st->execute($params)) {
            header("Location: ../information/情報登録6.html?syo=". urlencode($syo));
            exit();
        } else {
            echo "<script type='text/javascript'>
            alert('挿入に失敗しました。');
            window.location.href = '../information/情報登録5.html';
        </script>";
        exit();
        }
    } catch (PDOException $e) {
        echo "接続または操作に失敗しました: " . $e->getMessage();
    }
}
?>
