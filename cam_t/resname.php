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
        if(isset($_POST["s"])){
            $search = $_POST["s"];
            echo("<h4>商品名検索:{$search}</h4>");
            //$dsn="mysql:dbname=DB名;host=ホスト名";←要変更
            $dsn="mysql:dbname=shinadasi;host=localhost";
            //$my = new PDO(接続情報,ユーザ名, パスワード);←要変更
            $my = new PDO($dsn, "test", "testuser01");
            $sql = "SELECT JANコード, 商品名, メーカー,価格, 商品説明 FROM 商品 WHERE 商品名 LIKE ".$search."";
            $res = $my->prepare($sql);
            $res->execute();
            $html = "<h3>検索結果</h3><br>";
            if ($res -> rowCount() > 0) {
                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                    $html .= "<table border='1'><tr><th>JAN</th><th>商品名</th><th>メーカー</th><th>価格</th><th>説明</th></tr>";
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
    
        if(!isset($_POST["s"])){
            $html = "<h3>入力されていません</h3>";
            echo($html);
        }
        ?>
    </div>
    <button id="back-button" onclick="history.back()">戻る</button>
</body>
</html>