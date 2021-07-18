<?php
//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//Connection to database
$db = mysqli_select_db($link, "platform") or die ("Could not select database");

session_start();

$list = $link->prepare("SELECT savedlist.name AS List_Name, savedlist.cartID, savedList.name AS listName, products.DisplayName, products.Specs, products.Price, products.Platform FROM users JOIN linktable ON users.email = linktable.email JOIN savedlist ON linktable.cartID = savedlist.cartID JOIN products ON linktable.ProductID = products.ProductID WHERE users.email = ? ORDER BY savedlist.cartID ASC");
//$selectlistName = $link->prepare("SELECT DISTINCT savedlist.cartID AS CartID, savedlist.name AS List_Name FROM users JOIN linktable ON users.email = linktable.email JOIN savedlist ON linktable.cartID = savedlist.cartID JOIN products ON linktable.ProductID = products.ProductID WHERE users.email = ?");
//
//$selectlist = $link->prepare("SELECT savedlist.name AS List_Name, products.DisplayName, products.Specs, products.Price, products.Platform FROM users JOIN linktable ON users.email = linktable.email JOIN savedlist ON linktable.cartID = savedlist.cartID JOIN products ON linktable.ProductID = products.ProductID WHERE users.email = ? AND savedlist.cartID = ?");

if (!empty($_SESSION["email"])){
    
    $list->bind_param("s", $_SESSION['email']);
    $list->execute();
    $listResult = $list->get_result();
    
    //MOTHER ARRAY
    $resultArr = array();
    
    //LOOP DB RESULT
    if ($listResult -> num_rows > 0){
        while($listRow = $listResult->fetch_assoc()) {
            //print_r($listRow);
//            if (in_array($listRow['cartID'],$resultArr)) {
//                $cartID = $listRow['cartID'];
//            } else {
//                $cartID = $listRow['cartID'];
//                array_push($resultArr, $listRow['cartID']);
//            }
            array_push($resultArr, $listRow);
        }
        echo json_encode($resultArr);
    }
    
//    $selectlistName->bind_param("s", $_SESSION["email"]);
//    $selectlistName->execute();
//    $listNameresult = $selectlistName->get_result();
//    $listNameresultArr = array();
//    
//    if ($listNameresult->num_rows > 0){
//        while ($listName = $listNameresult->fetch_assoc()){
//            array_push($listNameresultArr, $listName);
//        }
//        
//        $listResultArr = array();
//        
//        foreach($listNameresultArr as $listNameitem){
//
//            $cartID = $listNameitem["CartID"];
//            $selectlist->bind_param("si", $_SESSION["email"], $cartID);
//            $selectlist->execute();
//            $listResult = $selectlist->get_result();
//        
//            if ($listResult->num_rows > 0){
//                while ($list = $listResult->fetch_assoc()){
//                    array_push($listNameitem, $list);
//                }
//            }
//        }
//        //echo json_encode($listResultArr);
//        print_r($listNameresultArr);
//    }
    
    
    //echo json_encode($listNameresultArr);
}
?>