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
        if(isset($_POST["s"])){
            $jn = $_POST["s"];
            //$dsn="mysql:dbname=DB名;host=ホスト名";←要変更
            $dsn="mysql:dbname=books;host=localhost";
            //$my = new PDO(接続情報,ユーザ名, パスワード);←要変更
            $my = new PDO($dsn, "test", "testuser01");
            $sql = "SELECT JAN, 商品名, メーカー, 説明 FROM 商品情報 WHERE JAN='.$jn.'";
            $array = $my->query($sql);
            foreach($arr as $row){
                $html = 
                "<p>{$row['JAN']}<br>
                {$row['商品名']}<br>
                {$row['メーカー']}<br>
                {$row['説明']}</p>";
            }
        }
        
        else{
            $html = "<h3>入力されていません</h3>";
        }
        echo($html);
        ?>
    </div>
    <button id="back-button" onclick="history.back()">戻る</button>
</body>
</html>