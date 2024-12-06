<?php 
$shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";
try {
    $count = 0;
    $my = new PDO($dsn, "sina", "sina");
    $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT カメラID FROM 棚 WHERE 棚番号 = :shelf";
    $st = $my->prepare($sql);
          $st->execute();
          $result = $st->fetchAll(PDO::FETCH_ASSOC);
          $link = $result["カメラID"];
          $link_encode= urlencode("$link");
          $url ="http://localhost:5000/camera_screen/$camera_id";
          if($result){
            header("Location:$url");
            exit();
          }else{
            echo "カメラがありません。";
          }
        } catch(PDOException $e) { 
            echo "エラー: ". $e->getMessage(); 
        } 
        ?>
          
          