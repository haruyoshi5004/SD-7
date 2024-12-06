<?php
session_start();
$dele_syo = $_SESSION['dele_syo']??'不明な商品';
unset($_SESSION['dele_syo']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除完了画面</title>
    <link rel="stylesheet" href="../information/style_info.css">
</head>
<body>
    <header class="header">
        情報削除
    </header>    
    <p><?php echo $dele_syo; ?>の情報を削除しました</p>

    <button class="logout-button" onclick="window.location.href='../top/Top.html'">ログアウト</button>

    <!-- 戻るボタン -->
    
    <a href="../information/情報登録2.html"><button class="back-button" onclick="history.back()">戻る</button></a>
</body>
</html>