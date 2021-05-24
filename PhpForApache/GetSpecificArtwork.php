<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$artworkID = $_POST["artworkID"];
$addview = "update artworks set view = view+1 where artworkID='".$artworkID."';";
$connection->query($addview);
$informationsql = "select * from artworks where artworkID='".$artworkID."';";
$result = $connection->query($informationsql);
$row = $result->fetch_assoc();
$return = array();
$return[0] = $row;
$seeifcollectsql = "select * from wishlist where artworkID=".$artworkID." and userID=1;";
$seeifcollectresult = $connection->query($seeifcollectsql);
if($seeifcollectresult->num_rows>0){
$iscollected = "1";
}
else{
$iscollected = "0";
}
$return[1] = $iscollected;
echo(json_encode($return));
?>
