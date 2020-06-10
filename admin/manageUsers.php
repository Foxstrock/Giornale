<?php
    include "header.php";

$result=$sql->query("SELECT * FROM (users NATURAL JOIN usersLevel)NATURAL JOIN levels ");

$row= $result->fetch_array(MYSQLI_NUM);

while($row=$result->fetch_array(MYSQLI_NUM)){
    print_r($row);
    echo "<br>";
}
