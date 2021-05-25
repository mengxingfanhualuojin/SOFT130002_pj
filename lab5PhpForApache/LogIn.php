<?php
$connection = new mysqli("localhost", "chenzhong", "123456","web");
$name = $_POST["name"];
$password = $_POST["password"];
$loginsql = "select * from users where name='".$name."' and password='".$password."';";
$loginsqlresult = $connection->query($loginsql);
$return = array();
if($loginsqlresult->num_rows == 0){
    $return[0] = 0;
    $connection->close();
    echo(json_encode($return));
}
else{
    $return[0] = 1;
    $return[1] = $loginsqlresult->fetch_assoc();
    $connection->close();
    echo(json_encode($return));

}