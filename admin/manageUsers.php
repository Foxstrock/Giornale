<?php
    include "header.php";

$result=$sql->query("SELECT * FROM users");
$num=$sql->query("COUNT * FROM users");
echo $num;