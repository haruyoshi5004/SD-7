<?php
if(isset($_POST["tana"])) {
    $tana = $_POST["tana"];
    $tana_encoded = urlencode($tana);
    header("Location:../Stocking/品出し2.html?shelf=$tana_encoded");

}
?>
