<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スーパーの管理項目</title>
    <link rel="stylesheet" href="情報登録8.css">
</head>
<body>
    <header class="header">
        情報登録
    </header>
    <div id="box">
        <?php
        $jan = $_POST["jan"];
        $sell = $_POST["sell"];
        $cate = $_POST["cate"];
        $number = $_POST["number"];
        $post = $_POST["rule"];
        $dsn="mysql:dbname=books;host=localhost";
        ?>
    </div>