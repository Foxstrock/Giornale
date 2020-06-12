<?php
    include "header.php";
    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if ($_SERVER['REQUEST_METHOD']=="GET"){
        $users = $sql->query("SELECT * FROM users");
        while($user = $users->fetch_assoc()){
            $userSelect .= "<option name='userID_".$user['userID']."'>".$user['name']." ".$user['surname']." - ".$user['email']."</option>";
        }
        ?>

        <select id="user" name="user">
            <?php echo $userSelect; ?>
        </select>

        <?php
    }else{

    }