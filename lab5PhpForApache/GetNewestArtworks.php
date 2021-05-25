<?php
header("Access-Control-Allow-Origin: *");
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$newsql = "select imageFileName,artist,title,description from artworks order by timeReleased desc limit 3";
$newresult = $connection->query($newsql);
$result = array();
while ($row=$newresult->fetch_assoc()) {
    $result[]=$row;
}
$connection->close();
//$result = $_POST["hello"];
echo (json_encode($result));
?>
