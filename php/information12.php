<?php
session_start();
$product = $_SESSION['product'] ?? null;
$error = $_SESSION['error'] ?? null;

// セッションデータをクリア
unset($_SESSION['product']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>情報削除</title>
    <link rel="stylesheet" href="../search/検索.css">
</head>
<body>
    <header class="header">
        情報検索結果
    </header>

    <div class="login-container">
        <?php if ($product): ?>
            <p>商品名: <?php echo $product['商品名']; ?></p>
            <p>メーカー: <?php echo $product['メーカー']; ?></p>
            <p>JANコード:<?php echo $product['Janコード']; ?></p>
            <p>価格: <?php echo $product['価格']; ?></p>
            <p>説明: <?php echo $product['商品説明']; ?></p>
            <form method ="post" action="information13.php">
                <input type= "hidden" name ="id" value=<?php echo $product["商品ID"];?>>
                <input type = "submit" value="削除" class="search-button2">
            </form>
        <?php elseif ($error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php else: ?>
            <p>商品情報がありません。</p>
        <?php endif; ?>
        <form method = "post" action="information11.php">
            <label for="syo-search">商品名検索</label>
            <input type="text" id="syo-search" name="syo"class="input-field">
            <input type = "submit" value="検索" class="search-button2">
        </form>
    </div>

    <!-- 戻るボタン -->
    <button class="back-button" onclick="history.back()">戻る</button>
</body>
</html>
