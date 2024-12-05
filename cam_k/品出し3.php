<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品一覧</title>
</head>
<body>
    <header>
        <h1>商品情報</h1>
    </header>
    <?php
    $shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
    $dsn = "mysql:dbname=shinadasi;host=localhost";

    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT 商品ID FROM 棚 WHERE 棚番号 = :shelf ORDER BY 商品ID ASC";
        $st = $my->prepare($sql);
        $st->bindParam(':shelf', $shelf, PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border=1>";
        echo "<tr><th>商品名</th></tr>";

        foreach($result as $row) {
            $re = $row['商品ID'];
            $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID= :re";
            $st = $my->prepare($sql);
            $st->bindParam(':re', $re, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                echo "<tr><td>";
                echo htmlspecialchars($result["商品名"]);
                echo "</td></tr>";
            }
        }
        echo "</table>";
    } catch(PDOException $e) {
        echo "エラー: " . htmlspecialchars($e->getMessage());
    }
    ?>
     <button class="back-button" onclick="window.location.href='../../top/TOP.html'">戻る</button>
</body>
</html>
