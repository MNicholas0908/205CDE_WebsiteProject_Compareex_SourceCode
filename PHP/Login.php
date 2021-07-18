<?php
$email = $_POST["email"];
$password = $_POST["password"];

//Connection to MySQL
$link = mysqli_connect("127.0.0.1", "root", "") or die ("Could not connect");

//Connection to database
$userdb = mysqli_select_db($link, "platform") or die ("Could not select database");

session_start();

$select = $link->prepare("SELECT email, password FROM users WHERE email = ? AND password = ?");
$select->bind_param("ss", $email, $password);
$select->execute();
$result = $select->get_result();

if ($result->num_rows == 0){
    echo "Login Failed";
}
else {
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;
}
?>