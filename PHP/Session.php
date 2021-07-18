<?php
session_start();

if (!isset($_SESSION["productID"])){
    $_SESSION["productID"] = array();
}

if (!empty($_SESSION["email"])){
    echo 1;
}
else {
    echo 0;
}
?>