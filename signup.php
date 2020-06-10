<?php
    include "header.php";
    if($_SERVER['REQUEST_METHOD']=="GET"){
?>

        <form action="#signup" method="POST">
            Nome:<br>
            <input type="text" id="name" name="name"><br>
            Cognome:<br>
            <input type="text" id="surname" name="surname"><br>
            E-Mail:<br>
            <input type="text" id="email" name="email"><br>
            Indirizzo:<br>
            <input type="text" id="address" name="address"><br>
            Data di Nascita:<br>
            <input type="date" id="birthdate" name="birthdate"><br>
            Password:<br>
            <input type="password" id="password" name="password"><br>
            Conferma password:<br>
            <input type="password" id="passwordConf" name="passwordConf"><br>
            <input type="submit" value="Invia">
        </form>
        <?php
    }elseif($_SERVER['REQUEST_METHOD']=="POST") {


        $Name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $birthdate = $_POST['birthdate'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
        $createdAt = date('Y-m-d H:i:s');

        if ($password !== $passwordConf) {
            echo "Le password non corrispondono";
            die();
        }
        $password = md5($passwordConf);

       $sql->query("INSERT INTO users (name, surname, email, address, birthdate, password, createdAt) VALUES ('$Name', '$surname', '$email', '$address', '$birthdate', '$password', '$createdAt')");

       if ($sql->error) {
           die($sql->error);
       }
        
       $id = mysqli_result($sql->query("SELECT userID FROM users WHERE email='$email'")-fetch_array()['userID'];
       if ($sql->error) {
           die($sql->error);
       }

       $sql->query("INSERT INTO userLevels (userID,levelID) VALUES ('$id', 0)");
       if ($sql->error) {
           die($sql->error);
       }
       header("location: login.php");
    }
?>
