<?php
    include "header.php";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        ?>
        <div style="text-align: center;" class="shadow p-3 mb-5 bg-white rounded">
            <h1>Reserved Area</h1>
            <form method="post" action="#login">
                E-Mail:<br>
                <input type="text" id="email" name="email"><br>
                Password:<br>
                <input type="password" id="password" name="password"><br>
                <input type="submit" id="login" name="login" value="Accedi!">
            </form>
        </div>
        <?php
    }elseif ($_SERVER['REQUEST_METHOD']=="POST"){
        if (isset($_POST['login'])){
            print_r($_POST);
            $username = $_POST['email'];
            $password = md5($_POST['password']);
            $password = trim($password, "\t\n\r\0\x0B");
            if($sql->query("SELECT * FROM users WHERE email='$username'")->num_rows > 0){
                if($sql->query("SELECT * FROM users WHERE email='$username' AND password='$password'")->num_rows > 0){
                    $user = $sql->query("SELECT * FROM users WHERE email='$username'")->fetch_array();
                    $_SESSION['user']['name'] = $user['name'];
                    $_SESSION['user']['surname'] = $user['surname'];
                    $_SESSION['user']['email'] = $user['email'];
                    $_SESSION['user']['id'] = $user['userID']; 
                    $userID = $user['userID'];
                    $levelID = $sql->query("SELECT levelID FROM userLevels WHERE userID='$userID'")->fetch_array()['levelID'];
                    $_SESSION['user']['levelID'] = $levelID;
                    $_SESSION['user']['levelName'] = $sql->query("SELECT name FROM levels WHERE levelID='$levelID'")->fetch_array()['name'];
 
                    header("location: index.php");
                }else{
                    die("Password errata");
                }
            }else{
                die("Utente non trovato.");
            }
        }
    }
