<?php
    include "header.php";

    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(!isset($_GET['action']) || $_GET['action'] == 'view'){
            //mostra utenti
            echo "<table><tr><td>UserID</td><td>Name</td><td>Surname</td><td>Email</td><td>Address</td><td>Birthdate</td><td>Created At</td><td>Status</td><td>Scadenza Abbonamento</td><td>Edit</td><td>Delete</td></tr>";
            $users = $sql->query("SELECT * FROM users");
            while ($user = $users->fetch_assoc()){
                $userID = $user['userID'];
                //inizio controllo
                $subscription = '';
                $sub = $sql->query("SELECT * FROM subscriptions WHERE userID = '$userID'");
                if($sub->num_rows == 0){
                    $subscription = "Nessun abbonamento attivo";
                }else{
                    $subscription = $sub->fetch_array()['expirationDate'];
                }
                $statusID = $sql->query("SELECT * FROM userStatus WHERE userID = '$userID'")->fetch_array()['statusID'];
                $statusName = $sql->query("SELECT * FROM status WHERE statusID = '$statusID'")->fetch_array()['name'];
                $data .= "<tr><td>".$user['userID']."</td><td>".$user['name']."</td><td>".$user['surname']."</td><td>".$user['email']."</td><td>".$user['address']."</td><td>".$user['birthdate']."</td><td>".$user['createdAt']."</td><td>".$statusName."</td><td>$subscription</td><td><a href='manageUsers.php?action=edit&userID=".$user['userID']."'>Edit</a></td><td><a href='manageUsers.php?action=delete&userID=".$user['userID']."'>Delete</a></td></tr>";
            }
            echo $data;
            echo "</table>";
        }elseif ($_GET['action'] == "edit"){
            //modifica
            $userID = $_GET['userID'];
            $user = $sql->query("SELECT * FROM users WHERE userID = '$userID'")->fetch_array();
            $currentStatusID = $sql->query("SELECT statusID from userStatus where userID = '$userID'")->fetch_array()['statusID'];
            $currentLevelID = $sql->query("SELECT levelID from userLevels where userID = '$userID'")->fetch_array()['levelID'];
            $currentStatusName = $sql->query("SELECT name FROM status WHERE statusID = '$currentStatusID'")->fetch_array()['name'];
            $currentLevelName = $sql->query("SELECT name FROM levels WHERE levelID = '$currentLevelID'")->fetch_array()['name'];
            $currentStatus = "<option name=\"statusID$currentStatusID\">$currentStatusName</option>";
            $currentLevel = "<option name=\"levelID$currentLevelID\">$currentLevelName</option>";
            ?>
            <form method="post" action="#">
                <input type="text" name="name" id="name" readonly value="<?php echo $user['name']; ?>">
                <input type="email" name="email" id="email" readonly value="<?php echo $user['email']; ?>">
                <select name="status" id="staus">
                    <?php echo $currentStatus; ?>
                    <option disabled>-------</option>
                    <option name="statusID1">Attesa</option>
                    <option name="statusID2">Attivo</option>
                    <option name="statusID3">Sospeso</option>
                </select>
                <select name="level" id="level">
                    <?php echo $currentLevel; ?>
                    <option disabled>-------</option>
                    <option name="levelID1">Non abbonato</option>
                    <option name="levelID2">Abbonato</option>
                    <option name="levelID3">Redattore</option>
                    <option name="levelID4">Direttore</option>
                </select>
                <input type="submit" name="submit" value="Modifica!">
            </form>
            <?php
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
        print_r($_POST);
        $newStatusName=$_POST['status'];

        if($newStatusName == "Attesa"){
            $newStatusID = 1;
        }
        if($newStatusName == "Attivo"){
            $newStatusID = 2;
        }
        if($newStatusName == "Sospeso"){
            $newStatusID = 3;
        }

        echo $newStatusID;

        //Cambio stato
        if($newStatusID != $currentStatusID = $sql->query("SELECT statusID from userStatus where userID = '$userID'")->fetch_array()['statusID']){
            $sql->query("UPDATE userStatus SET statusID = '$newStatusID' WHERE userID = '$userID'");
            if ($sql->error){
                die($sql->error);
            }
        }
        //Cambio Livello

    }
