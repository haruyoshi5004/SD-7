<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通知-記録</title>
    <link rel="stylesheet" href="通知.css">
</head>
<body>
    <header class="header">
        通知
    </header>

    <div class="container">
        <!-- 棚リスト -->
        <div class="shelf-list">
            <?php
            $dsn = "mysql:dbname=shinadasi;host=localhost";
            try{
                $my = new PDO($dsn, "sina", "sina");
                $sql = "SELECT * FROM 履歴";
                $st = $my->prepare($sql);
                $st->execute();
                $result = $st->fetchAll(PDO::FETCH_ASSOC);
                echo "<table>";
                    echo "<tr>";
                    foreach($result as $row){
                        echo "<td>";
                        echo $row["日付"];
                        echo "<br>";
                        echo $row["最終時間"];
                        echo "</td>";
                        echo "<td>";
                        echo "棚" . $row["棚"] . "が品出しの基準を満たしました​";
                        echo "</td>";
                        echo "<td>";
                        $tana =$row["棚"];
                        echo "<td><a href='../Stocking/品出し2.html?shelf=" . htmlspecialchars($row["棚"]) . "' class='detail-link'>詳細</a></td>";
                        echo "</tr>";
                    }
                }catch(PDOException $e){
                    echo "エラー" . $e->getMessage();
                }
                echo "</table>";
                ?>
        </div>
    </div>

    <!-- 戻るボタン -->
    <button class="back-button" onclick="history.back()">戻る</button>
</body>
</html>
