<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$artworkID = $_POST["artworkID"];
$collectsql = "insert into wishlist(userID,artworkID) values(1," . $artworkID . ")";
if($connection->query($collectsql)==true){
    echo(json_encode("1"));
}
else{
    echo(json_encode("0"));
}


?>
