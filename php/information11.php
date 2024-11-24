<?php
if (isset($_POST["syo"])) {
    try {
        $username = $_POST["user"];
        $dsn = "mysql:dbname=shinadasi;host=localhost";
        $my = new PDO($dsn, "sina", "sina");