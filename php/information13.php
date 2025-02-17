<?php
session_start();
if (isset($_POST["id"],$_POST["syod"])) {
    try {
        $syo = $_POST["syod"];
        $id = $_POST["id"];
        
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        $my = new PDO($dsn, "sina", "sina");

        $sql = "DELETE FROM 商品詳細 WHERE 商品ID = :id";
        $st = $my->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();

        $sql = "DELETE FROM 基準値 WHERE 商品ID = :id";
        $st = $my->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();

        $sql = "DELETE FROM 棚 WHERE 商品ID = :id";
        $st = $my->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();

        $sql = "DELETE FROM 商品 WHERE 商品ID = :id";
        $st = $my->prepare($sql);
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();

        $_SESSION['dele_syo'] = $syo;
        header("Location:information131.php");
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>