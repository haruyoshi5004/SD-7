<?php
$shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        $count = 0;
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT 商品ID FROM 棚 WHERE 棚番号 = :shelf ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':shelf', $shelf, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
        $syo=[];
        $kiz = [];
        $ziseki = [];
        foreach($result as $row) {
            $re = $row['商品ID'];
            $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $res = $st->fetch(PDO::FETCH_ASSOC);
            $syo[]=$res["商品名"];
            $sql = "SELECT 在庫数 FROM 商品詳細 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $resu = $st->fetch(PDO::FETCH_ASSOC);
            $ziseki[]=$resu["在庫数"];
            $count = $count + 1;
        }
    }catch(PDOException $e) {
        echo "エラー";
    }