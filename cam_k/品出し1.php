<!DOCTYPE HTML>
<html lang ="ja">
    <head>
        <meta charset ="utf-8">
        <title>商品一覧</title>
        <link rel="stylesheet" href="../information/style_info.css">
    </head>
    <body>
        <header class ="header">
            棚リスト
        </header>
        <?php
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        try{
            $my = new PDO($dsn, "sina", "sina");
            $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT shelf_id FROM shelf_positions ORDER BY shelf_id ASC";
            $st = $my->prepare($sql);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);
            echo '<div class="container">';
            echo "<div class='shelf-list'>";
            echo "<table>";
            foreach($result as $row){
                echo "<tr><td>";
                echo "棚" . htmlspecialchars($row['shelf_id']);
                echo "</td>";
                echo "<td>";
                echo "<form action ='syoken.php' method ='post'>";
                echo "<input type='hidden' name='tana' value='" . htmlspecialchars($row['shelf_id']) . "'>";
                echo "<input type = 'submit' value='詳細'>";
                echo "</form>";
                echo "</td></tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "</div>";
        } catch (PDOException $e) {
            echo "エラー: " . htmlspecialchars($e->getMessage());
        }
        ?>
        <button class="back-button" onclick="window.location.href='../top/TOP.html'">戻る</button>
        </body>
    </html>