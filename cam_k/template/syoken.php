<?php
if(isset($_POST["tana"])) {
    $tana = $_POST["tana"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $sql = "SELECT 商品ID FROM 棚 WHERE 棚番号 = :tana ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':tana', $tana, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);

        $syo = [];
        foreach($result as $row) {
            $re = $row['商品ID'];
            $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            $syo[] = $result["商品名"];
        }
        $syo_json = json_encode($syo);
        $syo_encoded = urlencode($syo_json);
        $tana_encoded = urlencode($tana);
        header("Location:../../Stocking/品出し2.html?syo=$syo_encoded&shelf=$tana_encoded");
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>
