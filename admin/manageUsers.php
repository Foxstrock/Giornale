<?php
    include "header.php";

    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(!isset($_GET['action']) || $_GET['action'] == 'view'){
            //mostra utenti
            echo "<table><tr><td>UserID</td><td>Name</td><td>Surname</td><td>Email</td><td>Address</td><td>Birthdate</td><td>Created At</td><td>Edit</td><td>Delete</td></tr>";
            $users = $sql->query("SELECT * FROM users");
            while ($user = $users->fetch_assoc()){
                $data .= "<tr><td>".$user['userID']."</td><td>".$user['name']."</td><td>".$user['surname']."</td><td>".$user['email']."</td><td>".$user['address']."</td><td>".$user['bithdate']."</td><td>".$user['createdAt']."</td><td><a href='manageUsers.php?action=edit&userID=".$user['userID']."'>Edit</a></td><td><a href='manageUsers.php?action=delete&userID=".$user['userID']."'>Delete</a></td></tr>";
            }
            echo "</table>"
        }elseif ($_GET['action'] == "edit"){
            //modifica
        }elseif ($_GET['action'] == "delete"){
            $userID = $_GET['userID'];
            $sql->query("DELETE FROM users WHERE userID = '$userID'");
            if($sql->error){
                die($sql->error);
            }else{
                header("location: manageUsers.php");
            }
        }
    }elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
        //modifica
    }
