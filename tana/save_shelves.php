<?php
$data = json_decode(file_get_contents("php://input"), true);
$dsn = "mysql:dbname=shinadasi;host=localhost";
$pdo = new PDO($dsn, "sina", "sina");

$sql = "TRUNCATE TABLE shelf_positions";
$pdo->exec($sql);

$sql = "INSERT INTO shelf_positions (shelf_id, x, y, width, height, selected) VALUES (:shelf_id, :x, :y, :width, :height, :selected)";
$stmt = $pdo->prepare($sql);

foreach ($data as $shelf) {
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
?>
