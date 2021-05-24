<?php
header("Access-Control-Allow-Origin: *");
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$topsql = "select imageFileName,title,description from artworks order by view desc limit 3";
$topresult = $connection->query($topsql);
$result = array();
while ($row=$topresult->fetch_assoc()) {
    $result[]=$row;
}
$connection->close();
//$result = $_POST["hello"];
echo (json_encode($result));
?>