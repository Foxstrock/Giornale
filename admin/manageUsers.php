<?php
    include "header.php";

$num=$sql->query("Select * from users")->num_rows;

$i=0;

while($i<$num){

    $name=mysqli_result($sql,$i,"name");
    $surname=mysqli_result($sql,$i,"surname");
    $email=mysqli_result($sql,$i,"email");
    $address=mysqli_result($sql,$i,"address");
    $birthdate=mysqli_result($sql,$i,"birthdate");

    echo "$name $surname $email $address $birthdate<br>";


    $i++;
}
