<?php
$connection = new mysqli("localhost", "chenzhong", "123456","web");
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$tel = $_POST["tel"];
$address = $_POST["address"];
$seewhethernameexistsql = "select * from users where name='".$name."'";
$seewhethernameexistresult = $connection->query($seewhethernameexistsql);
$return = array();
if($seewhethernameexistresult->num_rows>0){
    $return[0] = 0;
    $connection->close();
    echo(json_encode($return));
}
else{
    $return[0] = 1;
    $insertsql = "insert into users(name,email,password,tel,address) values('"
        .$name."','".$email."','".$password."','".$tel."','".$address."');";
    $connection->query($insertsql);
    $getuser = "select * from users where name='".$name."';";
    $getuserresult = $connection->query($getuser);
    $return[1] = $getuserresult->fetch_assoc();
    $connection->close();
    echo(json_encode($return));

}
