<?php
if(isset($_POST["syo"], $_POST["id"], $_POST["ko"], $_POST["time"])) {
    $syo = $_POST["syo"];
    $id = $_POST["id"];
    $ko = $_POST["ko"];
    $time = $_POST["time"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        
        // 商品IDを取得
        $sql = "SELECT 商品ID FROM 商品 WHERE 商品名 = :syo";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $syo, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $product_id = $result["商品ID"];
        
        // 棚IDを取得
        $sql = "SELECT id FROM shelf_positions WHERE shelf_id = :tana";
        $st = $my->prepare($sql);
        $st->bindParam(':tana', $id, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $shelves_id = $result["id"];
        
        // 棚テーブルに挿入
        $sql = "INSERT INTO 棚 (商品ID, 棚番号) VALUES (:syo, :id)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $product_id, ':id' => $id);
        $st->execute($params);
        
        // 基準値テーブルに挿入
        $sql = "INSERT INTO 基準値 (商品ID,shelf_id,実績, 時間) VALUES (:syo, :id, :ko, :time)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $product_id, ':id' => $shelves_id, ':ko' => $ko, ':time' => $time);
        if ($st->execute($params)) {
            header("Location:../information/情報登録9.html");
        } else {
            echo "挿入に失敗しました！";
        }
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
?>
