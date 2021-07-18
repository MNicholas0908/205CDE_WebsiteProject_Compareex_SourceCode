<?php
//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//Connection to database
$db = mysqli_select_db($link, "platform") or die ("Could not select database");

session_start();

$listName = $_GET["Query"];

$selectlistName = $link->prepare("SELECT savedlist.name FROM savedlist JOIN linktable ON savedlist.cartID = linktable.cartID JOIN users ON linktable.email = users.email WHERE users.email = ? AND savedlist.name = ?");
$selectlistName->bind_param("ss", $_SESSION["email"], $listName);
$selectlistName->execute();
$listNameResult = $selectlistName->get_result();

$insert = $link->prepare("INSERT INTO linktable(email, cartID, ProductID) VALUES (?, ?, ?)");

if ($listNameResult->num_rows < 1){
    //Create New List
    $insertnewList = $link->prepare("INSERT INTO savedlist (name) VALUE (?)");
    $insertnewList->bind_param("s", $listName);
    $insertnewList->execute();
    
    $cartID = $insertnewList->insert_id;

    foreach($_SESSION["productID"] as $productID){
        $insert->bind_param("sss", $_SESSION["email"], $cartID, $productID);
        $insert->execute();
    }
    unset($_SESSION["productID"]);
    echo "Success";
} else{
    echo "Failed";
}

?>