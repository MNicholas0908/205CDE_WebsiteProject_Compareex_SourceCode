<?php
session_start();

$productID = $_GET["Query"];

array_push($_SESSION["productID"], $productID);

//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//connection to database
$db = mysqli_select_db($link,"platform") or die ("Could not select database");

$select = $link->prepare("SELECT DisplayName, Specs, Price, Platform FROM `products` WHERE ProductID = ?");
$select->bind_param("s", $productID);
$select->execute();
$result = $select->get_result();

while ($row = $result->fetch_assoc()){
    echo json_encode($row);
}

?>