<?php
session_start();
//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//connection to database
$db = mysqli_select_db($link,"platform") or die ("Could not select database");

//echo json_encode($_SESSION["productID"]);

$select = $link->prepare("SELECT DisplayName, Specs, Price, Platform FROM `products` WHERE ProductID = ?");

$listResult = array();

//echo json_encode($_SESSION["productID"]);

foreach($_SESSION["productID"] as $productID){
    //echo json_encode($productID);
    $select->bind_param("s", $productID);
    $select->execute();
    $result = $select->get_result();
    
    //echo json_encode($row);
    
    while ($row = $result->fetch_assoc()){
        //echo json_encode($row);
        array_push($listResult, $row);
    }
}
echo json_encode($listResult);
?>