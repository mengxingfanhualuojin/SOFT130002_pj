<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$userID = $_POST["userID"];
$getUserInformationSql = "select * from users where userID = " . $userID;
$result = $connection->query($getUserInformationSql);
$row = $result->fetch_assoc();
$return = array();
$return[0] = $row;
$getUserCollectionSql = "select * from artworks where artworkID IN (select artworkID from wishlist where userID=".$userID.")";
$collection = $connection->query($getUserCollectionSql);
while ($row=$collection->fetch_assoc()) {
    $return[]=$row;
}
echo(json_encode($return));
?>