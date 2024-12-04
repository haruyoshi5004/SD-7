<?php
if(isset($_POST["syo"], $_POST["id"], $_POST["ko"], $_POST["time"],$_POST["cate"])) {
    $syo = $_POST["syo"];
    $id = $_POST["id"];
    $ko = $_POST["ko"];
    $time = $_POST["time"];
    $cate = $_POST["cate"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $sql = "SELECT 商品ID FROM 商品 WHERE 商品名 = :syo";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $syo, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $product_id = $result["商品ID"];
        $sql = "SELECT id FROM shelf_positions WHERE shelf_id = :tana";
        $st = $my->prepare($sql);
        $st->bindParam(':tana', $id, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $shelves_id = $result["id"];
        $sql = "SELECT 商品カテゴリーID FROM 商品カテゴリー WHERE 商品カテゴリー名 = :cate";
        $st = $my->prepare($sql);
        $st->bindParam(':cate', $cate, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        $cate_id = $result['商品カテゴリーID'];
        $sql = "INSERT INTO 棚 (商品ID, 棚番号) VALUES (:syo, :id)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $product_id, ':id' => $id);
        $st->execute($params);
        $sql = "INSERT INTO 基準値 (商品ID,棚ID,実績, 時間) VALUES (:syo, :id, :ko, :time)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $product_id, ':id' => $shelves_id, ':ko' => $ko, ':time' => $time);
        $sql = "INSERT INTO 商品詳細 (商品ID, 棚ID,商品カテゴリーID,在庫数) VALUES (:syo, :tana_id,:cate_id,:zaiko)";
        $st = $my->prepare($sql);
        $params = array(':syo' => $product_id, ':tana_id' => $shelves_id,':cate_id'=> $cate_id,':zaiko' => 0);
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
