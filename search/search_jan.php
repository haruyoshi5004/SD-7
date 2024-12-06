<?php
if(isset($_POST["s"])){
    $jan = $_POST["s"];
    $jan_encode = urlencode($jan);
    header("Location:検索.html?shelf=$jan_encoded");

}
?>
