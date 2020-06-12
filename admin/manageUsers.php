<?php
    include "header.php";

    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(!isset($_GET['action']) || $_GET['action'] == 'view'){
            //mostra utenti
            echo "<table><tr><td>UserID</td><td>Name</td><td>Surname</td><td>Email</td><td>Address</td><td>Birthdate</td><td>Created At</td><td>Status</td><td>Edit</td><td>Delete</td></tr>";
            $users = $sql->query("SELECT * FROM users");
            $status = $sql->query("SELECT * FROM status");
            while ($user = $users->fetch_assoc()){
                $data .= "<tr><td>".$user['userID']."</td><td>".$user['name']."</td><td>".$user['surname']."</td><td>".$user['email']."</td><td>".$user['address']."</td><td>".$user['bithdate']."</td><td>".$user['createdAt']."</td><td>".$status['name']"</td><td><a href='manageUsers.php?action=edit&userID=".$user['userID']."'>Edit</a></td><td><a href='manageUsers.php?action=delete&userID=".$user['userID']."'>Delete</a></td></tr>";
            }
            echo $data;
            echo "</table>";
        }elseif ($_GET['action'] == "edit"){
            //modifica
        }elseif ($_GET['action'] == "delete"){
            $userID = $_GET['userID'];
            $querys[] = "DELETE FROM userStatus WHERE userID = '$userID'";
            $querys[] = "DELETE FROM userLevels WHERE userID = '$userID'";
            $querys[] = "DELETE FROM subscriptions WHERE userID = '$userID'";
            $querys[] = "DELETE FROM creditCards WHERE userID = '$userID'";
            $querys[] = "UPDATE articles SET creatorID = 1 WHERE creatorID = '$userID'";
            $querys[] = "UPDATE articles SET lastEditorID = 1 WHERE lastEditorID = '$userID'";
            $querys[] = "DELETE FROM users WHERE userID = '$userID'";
            foreach ($querys as $query){
                $sql->query($query);
                if($sql->error){
                    die($sql->error);
                }else{
                    header("location: manageUsers.php");
                }
            }

        }
    }elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
        //modifica
    }
