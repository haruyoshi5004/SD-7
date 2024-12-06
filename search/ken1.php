<?php
$shelf = isset($_GET['syo']) ? intval($_GET['syo']) : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT 商品ID FROM 商品 WHERE 商品名 = :syo ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $shelf, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
        $syo_id = $result["商品ID"];
        $sql = "SELECT 棚ID FROM 商品詳細 WHERE 商品ID = :syo ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $syo_id, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
        $tana_ban=[];
        foreach($result as $row){
            $tana = $row["棚ID"];
            $sql = "SELECT 棚番号 FROM 棚 WHERE 棚ID = :tana";
            $st = $my->prepare($sql);
            $st->bindParam(':tana', $tana, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);
        }
        $shelf_encoded = urlencode(json_encode($tana_ban));
            header("Location:../Stocking/品出し2.html?shelf=$shelf_encode");
        echo "<table border=1>";
        echo "<tr><th>商品名</th></tr>";
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>
        alert('エラーです。');
        window.location.href = '../search/検索.html';
        </script>";
}

?>