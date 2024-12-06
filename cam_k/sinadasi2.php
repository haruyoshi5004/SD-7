<?php
$shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT 商品ID FROM 棚 WHERE 棚番号 = :shelf ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':shelf', $shelf, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
        $syo=[];
        $kiz = [];
        foreach($result as $row) {
            $re = $row['商品ID'];
            $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            $syo[]=$row["商品名"];
            $sql = "SELECT 商品名 FROM 基準値 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            $syo[]=$row["商品名"];

        foreach()
    }catch(PDOException $e) {


    }