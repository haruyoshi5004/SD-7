<!DOCTYPE HTML>
<html lang ="ja">
    <head>
        <meta charset ="utf-8">
        <title>商品一覧</title>
    </head>
    <body>
        <?php
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        try{
            $my = new PDO($dsn, "sina", "sina");
            $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT 棚番号 FROM 棚 ORDER BY 棚番号 ASC";
            $st = $my->prepare($sql);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border =1>";
            foreach($result as $row){
                echo "<tr><td>";
                echo "棚" . htmlspecialchars($row['棚番号']);
                echo "</td>";
                echo "<td>";
                echo "<form action ='syoken.php' method ='post'>";
                echo "<input type='hidden' name='tana' value='" . htmlspecialchars($row['棚番号']) . "'>";
                echo "<input type = 'submit' value='詳細'>";
                echo "</form>";
                echo "</td></tr>";
            }
            echo "</table>";
        } catch (PDOException $e) {
            echo "エラー: " . htmlspecialchars($e->getMessage());
        }
        ?>
        <button class="back-button" onclick="window.location.href='../top/TOP.html'">戻る</button>
        </body>
    </html>