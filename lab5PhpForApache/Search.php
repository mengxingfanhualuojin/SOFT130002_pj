<?php
$hostname = "localhost";
$username = "chenzhong";
$password = "123456";
$dbname = "web";
$connection = new mysqli($hostname, $username, $password,$dbname);
$according = $_POST["according"];
$sort = $_POST["sort"];
$searchcontent = $_POST["searchcontent"];
$searchsql = "";
switch ($according){
    case 1:{
        switch ($sort){
            case 1:{
                $searchsql="select * from artworks where title like '%".$searchcontent."%' order by price asc";
                break;
            }
            case 2:{
                $searchsql="select * from artworks where title like '%".$searchcontent."%' order by price desc";
                break;
            }
            case 3:{
                $searchsql="select * from artworks where title like '%".$searchcontent."%' order by view asc";
                break;
            }
            case 4:{
                $searchsql="select * from artworks where title like '%".$searchcontent."%' order by view desc";
                break;
            }
        }
        break;

    }
    case 2:{
        switch ($sort){
            case 1:{
                $searchsql="select * from artworks where description like '%".$searchcontent."%' order by price asc";
                break;
            }
            case 2:{
                $searchsql="select * from artworks where description like '%".$searchcontent."%' order by price desc";
                break;
            }
            case 3:{
                $searchsql="select * from artworks where description like '%".$searchcontent."%' order by view asc";
                break;
            }
            case 4:{
                $searchsql="select * from artworks where description like '%".$searchcontent."%' order by view desc";
                break;
            }
        }
        break;

    }
    case 3:{
        switch ($sort){
            case 1:{
                $searchsql="select * from artworks where artist like '%".$searchcontent."%' order by price asc";
                break;
            }
            case 2:{
                $searchsql="select * from artworks where artist like '%".$searchcontent."%' order by price desc";
                break;
            }
            case 3:{
                $searchsql="select * from artworks where artist like '%".$searchcontent."%' order by view asc";
                break;
            }
            case 4:{
                $searchsql="select * from artworks where artist like '%".$searchcontent."%' order by view desc";
                break;
            }
        }
        break;

    }
}
$result = $connection->query($searchsql);
$return = array();
$return[0] = $result->num_rows;
while ($row=$result->fetch_assoc()) {
    $return[]=$row;
}
$connection->close();
echo(json_encode($return));

?>