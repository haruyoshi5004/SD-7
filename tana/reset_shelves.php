<?php
try {
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $pdo = new PDO($dsn, "sina", "sina");

    // データベース接続エラー処理
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デバッグ用にデータベース接続が成功したか確認
    echo "データベース接続成功<br>";

    // テーブルを空にする
    $sql = "TRUNCATE TABLE shelf_positions";
    $pdo->exec($sql);

    echo "TRUNCATE実行成功<br>";
    echo "Success";

} catch (PDOException $e) {
    // エラー発生時に詳細なエラーメッセージを表示
    echo "エラー: " . $e->getMessage();
}
?>
