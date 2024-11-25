<?php
if(isset($_POST["syo"],$_POST["id"],$_POST["ko"],$_POST["time"])){
    $syo =$_POST["syo"];
    $id = $_POST["id"];
    $ko =$_POST["ko"];
    $time =$_POST["time"];
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $sql ="INSERT INTO 棚(商品ID,棚番号) Value (':syo',':id')";
        $st = $my->prepare($sql);
        $params = array(':syo'=>$syo,':id'=> $id);
        $st->execute();
        if ($st->execute($params)) {
            echo "挿入成功";
        } else {
            echo "挿入に失敗しました！";
        }
        $sql ="INSERT INTO 基準値(商品ID,棚ID) Value (':syo',':id')";
        $st = $my->prepare($sql);
        $params = array(':syo'=>$syo,':id'=> $id);
        $st->execute();
}