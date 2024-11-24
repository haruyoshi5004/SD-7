<?php
try {
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $pdo = new PDO($dsn, "sina", "sina");

    // データベース接続エラー処理
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM shelf_positions";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
