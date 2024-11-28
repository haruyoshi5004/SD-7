<?php
try {
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $pdo = new PDO($dsn, "sina", "sina");

    // データベース接続エラー処理
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // テーブルを空にする
    $sql = "TRUNCATE TABLE shelf_positions";
    $pdo->exec($sql);

    // 初期データの挿入
    $initialShelves = [
        ['id' => 1, 'x' => 100, 'y' => 100, 'width' => 100, 'height' => 50, 'selected' => 0],
        ['id' => 2, 'x' => 200, 'y' => 100, 'width' => 100, 'height' => 50, 'selected' => 0],
        // 他の棚も追加
    ];
    $sql = "INSERT INTO shelf_positions (shelf_id, x, y, width, height, selected) VALUES (:shelf_id, :x, :y, :width, :height, :selected)";
    $stmt = $pdo->prepare($sql);

    foreach ($initialShelves as $shelf) {
        $stmt->execute([
            ':shelf_id' => $shelf['id'],
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
