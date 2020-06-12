<?php
    $email=_GET['email'];

    $userID = $sql->query("SELECT * FROM users WHERE email='$email'")->fetch_array()['userID'];
    if($sql->error){
        die($sql->error);
    }

    $sql->query("INSERT INTO userStatus (userID, userStatus) VALUES ('$userID', 2)");
    if($sql->error){
        die($sql->error);
    }

    header("location: index.php");