<?php
try {
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $pdo = new PDO($dsn, "sina", "sina");

    // データベース接続エラー処理
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブルを空にする
    $sql = "TRUNCATE TABLE shelf_positions";
    $pdo->exec($sql);

    echo "Success";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
