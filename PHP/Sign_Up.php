<?php
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//Connection to database
$userdb = mysqli_select_db($link, "platform") or die ("Could not select database");

session_start();

$select = $link->prepare("SELECT email FROM users");
$select->execute();
$result = $select->get_result();

$insert = $link->prepare("INSERT INTO users (email, name, password) VALUES (?, ?, ?)");
$insert->bind_param("sss", $email, $username, $password);

while ($row = $result->fetch_assoc()){
    if ($email == $row["email"]){
        echo "The email already has an account. Proceed to login";
    }
    else {
        $insert->execute();
        $_SESSION["name"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
    }
}
?>