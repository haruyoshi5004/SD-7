<?php
$camera_ids =[];
for(i = 0; i<=46; i++){
  $camera_ids = i; 
}

$dsn = "mysql:dbname=shinadasi;host=localhost";

try {
    $my = new PDO($dsn, "sina", "sina");
    $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($camera_ids as $camera_id) {
        $sql = "INSERT INTO camera (カメラ番号) VALUES (:camera_id)";
        $st = $my->prepare($sql);
        $st->bindParam(':camera_id', $camera_id, PDO::PARAM_INT);
        $st->execute();
    }

    echo "カメラIDが設定されました";
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
