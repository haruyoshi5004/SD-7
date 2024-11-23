<?php
$dsn = "mysql:dbname=shinadasi;host=localhost";
$pdo = new PDO($dsn, "sina", "sina");

$sql = "SELECT * FROM shelf_positions";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
?>
