<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/情報登録3.css">
    <title>カメラ画面</title>
    <script>
        // 商品数を更新
        function updateProductCount() {
            fetch('/get_count')
                .then(response => response.json())
                .then(data => {
                    // 商品数を個別に更新
                    const counts = data.product_counts;
                    for (let i = 0; i < counts.length; i++) {
                        document.getElementById(`product-${i + 1}`).innerText = counts[i];
                    }
                })
                .catch(error => console.error('エラー:', error));
        }

        // 1秒ごとに商品数を更新
        setInterval(updateProductCount, 1000);
    </script>

    
</head>
<body>
    <h1>カメラ画面</h1>
    <div>
        <img src="{{ url_for('video_feed') }}" alt="カメラ映像">
    </div>

    <div id="product-counts">
        <div>商品A: <span id="product-1">10</span> 個</div>
        <div>商品B: <span id="product-2">10</span> 個</div>
        <div>商品C: <span id="product-3">10</span> 個</div>
        <div>商品D: <span id="product-4">10</span> 個</div>
        <div>商品E: <span id="product-5">10</span> 個</div>
        <div>商品F: <span id="product-6">10</span> 個</div>
        <div>商品G: <span id="product-7">10</span> 個</div>
        <div>商品H: <span id="product-8">10</span> 個</div>
        <div>商品I: <span id="product-9">10</span> 個</div>
    </div>
    <?php
    $shelf = isset($_GET['shelf']) ? intval($_GET['shelf']) : null;
    $a = '<a href="/static/品出し3.php?shelf=" $shelf'">";
        <button class="registration-button">詳細</button>
        
</body>
</html>
