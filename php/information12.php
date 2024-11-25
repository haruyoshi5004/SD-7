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
    <title>情報登録-情報削除</title>
    <link rel="stylesheet" href="../search/検索.css">
</head>
<body>
    <header class="header">
        削除情報検索結果
    </header>

    <div class="login-container">
        <?php if ($product): ?>
            <p>商品名: <?php echo htmlspecialchars($product['商品名'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Janコード: <?php echo htmlspecialchars($product['Janコード'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>価格: <?php echo htmlspecialchars($product['価格'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>商品説明: <?php echo htmlspecialchars($product['商品説明'], ENT_QUOTES, 'UTF-8'); ?></p>
            <!-- 他のフィールドも追加 -->
        <?php elseif ($error): ?>
            <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php else: ?>
            <p>商品情報がありません。</p>
        <?php endif; ?>

        <form action="情報登録12.html" method="post">
            <label for="merchandise-search">商品</label>
            <input type="text" id="merchandise-search" name="merchandise-search" class="input-field">
            <button type="submit" class="search-button2">検索</button>
        </form>
        <form action="情報登録13.html" method="post">
            <button type="submit" class="search-button2">削除</button>
        </form>
    </div>

    <!-- 戻るボタン -->
    <button class="back-button" onclick="history.back()">戻る</button>
</body>
</html>
