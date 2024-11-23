<?php
try {
    $data = json_decode(file_get_contents("php://input"), true);
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $pdo = new PDO($dsn, "sina", "sina");

    // データベース接続エラー処理
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブルを空にする
    $sql = "TRUNCATE TABLE shelf_positions";
    $pdo->exec($sql);

    // データの挿入
    $sql = "INSERT INTO shelf_positions (shelf_id, x, y, width, height, selected) VALUES (:shelf_id, :x, :y, :width, :height, :selected)";
    $stmt = $pdo->prepare($sql);

    foreach ($data as $shelf) {
        $stmt->execute([
            ':shelf_id' => $shelf['shelf_id'], // 'id' から 'shelf_id' へ修正
            ':x' => $shelf['x'],
            ':y' => $shelf['y'],
            ':width' => $shelf['width'],
            ':height' => $shelf['height'],
            ':selected' => $shelf['selected']
        ]);
    }
    echo "Success";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
