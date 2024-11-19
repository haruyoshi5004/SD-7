<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset="UTF-8">
    <title>バーコードスキャン</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <h1>検索結果</h1>
    </header>
    <div id="box">
        <?php
        if(isset($_POST["code"])){
            $jn = $_POST["code"];
            echo("<h4>JANコード検索:{$jn}</h4>");
            //$dsn="mysql:dbname=DB名;host=ホスト名";←要変更
            $dsn="mysql:dbname=books;host=localhost";
            //$my = new PDO(接続情報,ユーザ名, パスワード);←要変更
            $my = new PDO($dsn, "test", "testuser01");
            echo("接続成功");
            $sql = "SELECT JAN, 商品名, メーカー, 説明 FROM 商品情報 WHERE JAN=".$jn."";
            $html = "<h3>検索結果</h3><br>";
            $html .= "<table border='0.5'><tr><th>JANコード</th><th>商品名</th><th>メーカー</th><th>説明</th></tr>";
            $res = $my->prepare($sql);
            $res->execute();
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $html .="<tr>";
                foreach($row as $item) $html .= "<td>{$item}</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
            echo($html);
        }
        
        if(!isset($_POST["code"])){
            $html = "<h3>入力されていません</h3>";
            echo($html);
        }
        ?>
    </div>
    <button id="back-button" onclick="history.back()">戻る</button>
</body>
</html>