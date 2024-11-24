<?php
if (isset($_POST["syo"])) {
    try {
        $name = $_POST["syo"];
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        $my = new PDO($dsn, "sina", "sina");
        $sql = "SELECT * FROM 商品 WHERE 商品名 = :syo";
        $st = $my->prepare($sql);
        $st->bindParam(':syo', $name, PDO::PARAM_STR);
        $st->execute();
        $result = $st->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo json_encode($result);
        }else{
            echo json_encode(["商品がありません" => $e ->getMessage()]);
        }
    }catch(PDPException $e){
        $SESSION['商品がありません']=$e->getMessage();
    }
    header("Location: information12.php");
?>