<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$artworkID = $_POST["artworkID"];
$userID = $_POST["userID"];
$uncollectsql = "delete from wishlist where userID=".$userID." and artworkId=" . $artworkID;
if($connection->query($uncollectsql)==true){
    echo(json_encode("1"));
}
else{
    echo(json_encode("0"));
}


?>
