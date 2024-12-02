<?php
$dsn = "mysql:dbname=shinadasi;host=localhost";
try {
    $my = new PDO($dsn, "sina", "sina");
    $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT 商品カテゴリー名 FROM 商品カテゴリー";
    $st = $my->prepare($sql);
    $st->execute();
    $categories = $st->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($categories);
} catch(PDOException $e) {
    echo json_encode(["error" => "エラー: " . $e->getMessage()]);
}
?>
