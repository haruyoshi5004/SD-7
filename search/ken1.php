<?php
$shelf = isset($_GET['syo']) ? $_GET['syo'] : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";

try {
    $my = new PDO($dsn, "sina", "sina");
    $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 商品ID FROM 商品 WHERE 商品名 = :syo ORDER BY 商品ID ASC";
    $st = $my->prepare($sql);
    $st->bindParam(':syo', $shelf, PDO::PARAM_STR);
    $st->execute();
    $result = $st->fetchAll(PDO::FETCH_ASSOC);

    $syo_id = [];
    foreach ($result as $row) {
        $syo_id[] = $row["商品ID"];
    }

    $tana_ban = [];
    foreach ($syo_id as $id) {
        $sql = "SELECT 棚ID FROM 商品詳細 WHERE 商品ID = :syo ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $id, PDO::PARAM_INT);
        $st->execute();
        $resul = $st->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resul as $row) {
            $tana = $row["棚ID"];
            $sql = "SELECT 棚番号 FROM 棚 WHERE 棚ID = :tana";
            $st = $my->prepare($sql);
            $st->bindParam(':tana', $tana, PDO::PARAM_INT);
            $st->execute();
            $resu = $st->fetchAll(PDO::FETCH_ASSOC);  
            foreach($resu as $row){
                $tanan = $row["棚番号"];
            }
        }
    }
    $tana_encorde = urlencode($tanan);
    header("Location:品出し2.html?shelf=$tana_encorde");
    exit();
} catch (PDOException $e) {
    echo "<script type='text/javascript'>
    alert('エラーです。');
    window.location.href = '../search/検索.html';
    </script>";
}
?>
