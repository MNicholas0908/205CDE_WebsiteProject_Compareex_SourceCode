<?php
//capture GET value from front end
$query = "%".$_GET["Query"]."%";
$query = preg_replace('/\s+/', '', $query);
//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//connection to database
$db = mysqli_select_db($link,"platform") or die ("Could not select database");

session_start();

//SQL Query for search results
$select = $link->prepare("SELECT ProductID, DisplayName, Specs, MIN(Price) AS Price, Platform FROM `products` WHERE ProductName LIKE ? GROUP BY DisplayName, Specs ORDER BY Price ASC");
$select->bind_param("s", $query);
$select->execute();
$result = $select->get_result();
$resultArr = array();


if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        //echo "Product: ".$row["DisplayName"]." - Specs: ".$row["Specs"]." - Price: ".$row["Price"]." - Platform: ".$row["Platform"];
        array_push($resultArr,$row);
    }
}
echo json_encode($resultArr);
?>