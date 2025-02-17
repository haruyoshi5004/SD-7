<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <h1>検索結果</h1>
    </header>
    <div id="box">
        <?php
        if(isset($_POST["sk"])){
            $search = $_POST["sk"];
            echo("<h4>カテゴリ(メーカー)検索:{$search}</h4>");
            //$dsn="mysql:dbname=DB名;host=ホスト名";←要変更
            $dsn="mysql:dbname=shinadasi;host=localhost";
            //$my = new PDO(接続情報,ユーザ名, パスワード);←要変更
            $my = new PDO($dsn, "sina", "sina");
            $sql = "SELECT メーカー, 商品名, JANコード,価格, 商品説明 FROM 商品 WHERE メーカー=".$search."";
            $res = $my->prepare($sql);
            $res->execute();
            $html = "<h3>検索結果</h3><br>";
            if ($res -> rowCount() > 0) {
                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                    $html .= "<table border='0'><tr><th>メーカー</th><th>商品名</th><th>JAN</th><th>価格</th><th>商品説明</th></tr>";
                    $html .="<tr>";
                    foreach($row as $item) $html .= "<td>{$item}</td>";
                    $html .= "</tr>";
                    $html .= "</table>";
                }
            }
            else{
                $html.= "<h2>*該当する商品がありません*</h2>";
            }
            echo($html);
        }
        elseif(isset($_POST["sn"])){
            $search = $_POST["sn"];
            echo("<h4>商品名検索:{$search}</h4>");
            //$dsn="mysql:dbname=DB名;host=ホスト名";←要変更
            $dsn="mysql:dbname=shinadasi;host=localhost";
            //$my = new PDO(接続情報,ユーザ名, パスワード);←要変更
            $my = new PDO($dsn, "sina", "sina");
            $sql = "SELECT JANコード, 商品名, メーカー,価格, 商品説明 FROM 商品 WHERE 商品名 LIKE ".$search."";
            $res = $my->prepare($sql);
            $res->execute();
            $html = "<h3>検索結果</h3><br>";
            if ($res -> rowCount() > 0) {
                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                    $html .= "<table border='0'><tr><th>JAN</th><th>商品名</th><th>メーカー</th><th>価格</th><th>説明</th></tr>";
                    $html .="<tr>";
                    foreach($row as $item) $html .= "<td>{$item}</td>";
                    $html .= "</tr>";
                    $html .= "</table>";
                }
            }
            else{
                $html.= "<h2>*該当する商品がありません*</h2>";
            }
            echo($html);
        }
        ?>
        </div>
        <button id="back-button" onclick="history.back()">戻る</button>
    </body>
    </html>