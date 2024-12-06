<?php
if (isset($_POST["s"], $_POST["syo"], $_POST["category"])) {
    $jan = $_POST["s"];
    $syo = $_POST["syo"];
    $cate = $_POST["category"];

    $dsn = "mysql:dbname=shinadasi;host=localhost";
    try {
        $my = new PDO($dsn, "sina", "sina");
        $my->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($jan == "" && $syo == "") {
            $sql = "SELECT 商品カテゴリーID FROM 商品カテゴリー WHERE 商品カテゴリー名 = :cate";
            $st = $my->prepare($sql);
            $st->bindParam(':cate', $cate, PDO::PARAM_STR);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            $cate_id = $result["商品カテゴリーID"];

            $sql = "SELECT 商品ID FROM 商品詳細 WHERE 商品カテゴリーID = :id";
            $st = $my->prepare($sql);
            $st->bindParam(':id', $cate_id, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($result as $row) {
                $syo_id = $row["商品ID"];
                $sql = "SELECT 商品名 FROM 商品 WHERE 商品ID = :id";
                $st = $my->prepare($sql);
                $st->bindParam(':id', $syo_id, PDO::PARAM_INT);
                $st->execute();
                $product = $st->fetch(PDO::FETCH_ASSOC);
                $products[] = $product["商品名"];
            }
            $products_encoded = urlencode(json_encode($products));
            header("Location:検索結果2.html?syo=$products_encoded");
        } elseif ($syo == "" && $cate == "") {
            $sql = "SELECT 商品名 FROM 商品 WHERE Janコード = :jan";
            $st = $my->prepare($sql);
            $st->bindParam(':jan', $jan, PDO::PARAM_STR);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            $product_encoded = urlencode($result["商品名"]);
            header("Location:検索結果3.html?syo=$product_encoded");
        } elseif ($jan == "" && $cate == "") {
            $sql = "SELECT 商品名 FROM 商品 WHERE 商品名 LIKE :syo";
            $st = $my->prepare($sql);
            $syo_like = "%" . $syo . "%";
            $st->bindParam(':syo', $syo_like, PDO::PARAM_STR);            
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);
            $products = [];
            foreach ($result as $row) {
                $products[] = $row["商品名"];
            }
            $products_encoded = urlencode(json_encode($products));
            header("Location:検索結果1.html?syo=$products_encoded");
        } else {
            echo "<script type='text/javascript'>
            alert('入力エラーです。');
            window.location.href = '../search/検索.html';
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script type='text/javascript'>
        alert('エラーです。');
        window.location.href = '../search/検索.html';
        </script>";
    }
}
?>
