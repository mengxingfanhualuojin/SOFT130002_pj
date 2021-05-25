<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$userID = $_POST["userID"];
$artworkID = $_POST["artworkID"];
$collectsql = "insert into wishlist(userID,artworkID) values(".$userID."," . $artworkID . ")";
if($connection->query($collectsql)==true){
    $connection->close();
    echo(json_encode("1"));
}
else{
    $connection->close();
    echo(json_encode("0"));
}


?>
