<?php
$shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
$dsn = "mysql:dbname=shinadasi;host=localhost";

try {
    $count = 0;
    $my = new PDO($dsn, "sina", "sina");
    $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT 商品ID FROM 棚 WHERE 棚番号 = :shelf ORDER BY 商品ID ASC";
    $st = $my->prepare($sql);
    $st->bindParam(':shelf', $shelf, PDO::PARAM_INT);
    $st->execute();
    $result = $st->fetchAll(PDO::FETCH_ASSOC);
    $syo = [];
    $ziseki = [];
    foreach($result as $row) {
        $re = $row['商品ID'];
        $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID= :re";
        $st = $my->prepare($sql);
        $st->bindParam(':re', $re, PDO::PARAM_INT);
        $st->execute();
        $res = $st->fetch(PDO::FETCH_ASSOC);
        $syo[] = $res["商品名"];
        $sql = "SELECT 在庫数 FROM 商品詳細 WHERE 商品ID= :re";
        $st = $my->prepare($sql);
        $st->bindParam(':re', $re, PDO::PARAM_INT);
        $st->execute();
        $resu = $st->fetch(PDO::FETCH_ASSOC);
        $ziseki[] = $resu["在庫数"];
        $count++;
    }

    // データをJSON形式にエンコード
    $data = [
        'count' => $count
    ];
    $json_data = json_encode($data);

    // Pythonサーバーにデータを送信
    $url = 'http://127.0.0.1:5000/receive_data';
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $json_data,
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        echo "エラー";
    } else {
        echo "データ送信成功";
    }
} catch(PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>