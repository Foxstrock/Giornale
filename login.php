<?php
    include "header.php";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        ?>
        <form method="post" action="#login">
            <input type="text" id="username" name="username"><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" id="login" name="login" value="Accedi!">
        </form>
        <?php
    }elseif ($_SERVER['REQUEST_METHOD']=="POST"){
        if (isset($_POST['login'])){
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            if($sql->query("SELECT * FROM users WHERE username='$username'")->num_rows > 0){
                if($sql->query("SELECT * FROM users WHERE username='$username' AND passsword='$password'")->num_rows > 0){
                    $user = $sql->query("SELECT * FROM users WHERE username='$username'")->fetch_array();
                    $_SESSION['user']['name'] = $user['name'];
                    $_SESSION['user']['surname'] = $user['surname'];
                    $_SESSION['user']['email'] = $user['email'];
                    $_SESSION['user']['id'] = $user['userID'];
                }else{
                    die("Password errata");
                }
            }else{
                die("Utente non trovato.");
            }
        }
    }