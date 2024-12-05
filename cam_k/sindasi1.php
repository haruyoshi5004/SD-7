<?php
    $dsn = "mysql:dbname=shinadasi;host=localhost";
    $my = new PDO($dsn, "sina", "sina");

    // SQL文（パスワードを取得）
    $sql = "SELECT shelf_id FROM shelf_positions";
    // SQL準備
    $st = $my->prepare($sql);
    $st->execute();
    // 結果を取得
    $result = $st->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "utf-8">
        <title>棚状況検索</title>
    </head>
    <table>
        <tr>
            <td>棚番号</td>
            <td></td>
        <tr>
        
    
            
</html>