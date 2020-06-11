<?php
/**
* Workflow
* check installato in tabella sistema e versione -> inizio -> check ambiente -> creazione tabelle -> popolazione tabelle -> creazione primo utente -> configurazione base -> popolazione record installato e versione db
*/
    include "config.php";
    $dbVersion = 2;

    //Initialize querys variable
    $querys=[];

    //Check for PHP Version
    if(PHP_VERSION_ID < 70311){
        die("Minimum PHP Version supported is 7.3.11\r\nUpgrade your PHP version and try again.");
    }

    if(!isset($_GET['_Step']) || $_GET['_Step'] == 1) {
        //check if installed and db version
        $installed = $sql->query("SELECT * FROM system WHERE name = 'installed'");
        if ($installed->num_rows >= 1) {
            $dbInstalledVersion = $sql->query("SELECT * FROM system WHERE name = 'databaseVersion'");
            $dbInstalledVersion = $dbInstalledVersion->fetch_array()['value'];
            if ($dbInstalledVersion = $dbVersion) {
                die("Database Version: $dbInstalledVersion<br>Already installed and up to date");
            }
            if($dbInstalledVersion == 1){
                $sql->query("ALTER TABLE articles ADD COLUMN mimeType longtext");
                $sql->query("UPDATE system SET value=2 WHERE name='dbInstalledVersion'");
            }
        } else {
            //Install 1.0
            //DROP TABLES
            $querys[] = "DROP TABLE IF EXISTS userStatus";
            $querys[] = "DROP TABLE IF EXISTS userLevels";
            $querys[] = "DROP TABLE IF EXISTS articles";
            $querys[] = "DROP TABLE IF EXISTS creditCards";
            $querys[] = "DROP TABLE IF EXISTS status";
            $querys[] = "DROP TABLE IF EXISTS levels";
            $querys[] = "DROP TABLE IF EXISTS system";
            $querys[] = "DROP TABLE IF EXISTS categories";
            $querys[] = "DROP TABLE IF EXISTS users";

            //Status table
            $querys[] = "CREATE TABLE status (statusID int NOT NULL PRIMARY KEY AUTO_INCREMENT, name varchar(200) NOT NULL, active tinyint NOT NULL) Engine=InnoDB";
            //userStatus table
            $querys[] = "CREATE TABLE userStatus (statusID int NOT NULL, userID int NOT NULL) Engine=InnoDB";
            //Levels table
            $querys[] = "CREATE TABLE levels (levelID int NOT NULL PRIMARY KEY AUTO_INCREMENT, name varchar(200) NOT NULL, subscriber tinyint NOT NULL, editor tinyint NOT NULL, director tinyint NOT NULL) Engine=InnoDB";
            //userLevels table
            $querys[] = "CREATE TABLE userLevels (levelID int NOT NULL, userID int NOT NULL) Engine=InnoDB";
            //System Table
            $querys[] = "CREATE TABLE system (settingID int NOT NULL PRIMARY KEY AUTO_INCREMENT, name varchar(200) NOT NULL, value longtext NOT NULL) Engine=InnoDB";
            //Categories Table
            $querys[] = "CREATE TABLE categories (categoryID int NOT NULL PRIMARY KEY AUTO_INCREMENT, name varchar(200) NOT NULL) Engine=InnoDB";
            //Articles Table
            $querys[] = "CREATE TABLE articles (articleID int NOT NULL PRIMARY KEY AUTO_INCREMENT,title longtext NOT NULL,subtitle longtext NOT NULL,text longtext NOT NULL,attachment longtext NOT NULL,createdAt datetime NOT NULL,creatorID int NOT NULL,lastEditorID int NOT NULL,lastEdited datetime NOT NULL,categoryID int NOT NULL) Engine=InnoDB";
            //Users table
            $querys[] = "CREATE TABLE users (userID int NOT NULL PRIMARY KEY AUTO_INCREMENT, name varchar(200) NOT NULL, surname varchar(200) NOT NULL, email varchar(200) NOT NULL, address varchar(200), birthdate date NOT NULL, password varchar(200) NOT NULL, createdAt datetime NOT NULL) Engine=InnoDB";
            //Credit Cards table
            $querys[] = "CREATE TABLE creditCards (cardID int NOT NULL PRIMARY KEY AUTO_INCREMENT, cardNumber varchar(19) NOT NULL, cardExpiration date NOT NULL, cardCVV int NOT NULL, cardHolderName varchar(200) NOT NULL, cardHolderSurname varchar(200) NOT NULL, cardHolderAddress varchar(200) NOT NULL, userID int NOT NULL)";

            //Alter tables to add auto forgein keys
            $querys[] = "ALTER TABLE userStatus ADD FOREIGN KEY (statusID) REFERENCES status(statusID)";
            $querys[] = "ALTER TABLE userStatus ADD FOREIGN KEY (userID) REFERENCES users(userID)";
            $querys[] = "ALTER TABLE userLevels ADD FOREIGN KEY (levelID) REFERENCES levels(levelID)";
            $querys[] = "ALTER TABLE userLevels ADD FOREIGN KEY (userID) REFERENCES users(userID)";
            $querys[] = "ALTER TABLE articles ADD FOREIGN KEY (categoryID) REFERENCES categories(categoryID)";
            $querys[] = "ALTER TABLE articles ADD FOREIGN KEY (creatorID) REFERENCES users(userID)";
            $querys[] = "ALTER TABLE articles ADD FOREIGN KEY (lastEditorID) REFERENCES users(userID)";
            $querys[] = "ALTER TABLE creditCards ADD FOREIGN KEY (userID) REFERENCES users(userID)";

            //Create user levels
            $querys[] = "INSERT INTO levels (name, subscriber, editor, director) VALUES ('Utente', 0, 0, 0)";
            $querys[] = "INSERT INTO levels (name, subscriber, editor, director) VALUES ('Abbonato', 1, 0, 0)";
            $querys[] = "INSERT INTO levels (name, subscriber, editor, director) VALUES ('Redattore', 1, 1, 0)";
            $querys[] = "INSERT INTO levels (name, subscriber, editor, director) VALUES ('Direttore', 1, 1, 1)";

            foreach ($querys as $query) {
                $sql->query($query);
                if ($sql->error) {
                    die($sql->error);
                }
            }

            header("location: install.php?_Step=2");

        }

    }elseif ($_GET['_Step']==2){
        ?>
        <form method="post" action="#">
            <label for="name">Nome: </label>
            <input type="text" name="name" id="name" placeholder="Nome"><br>
            <label for="surname">Cognome: </label>
            <input type="text" name="surname" id="surname" placeholder="Cognome"><br>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" placeholder="Email"><br>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password"><br>
            <label for="passwordConfirm">Conferma Password: </label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Password"><br>
            <label for="address">Indirizzo: </label>
            <input type="text" name="address" id="address" placeholder="Indirizzo"><br>
            <label for="birthday">Data di nascita:</label>
            <input type="date" name="birthdate" id="birthday" name="birthday"><br>
            <input type="submit" id="firstAccount" name="firstAccount" value="Registrati!">
        </form>
        <?php
    }elseif ($_GET['_Step'] == 3){
        $querys[] = "INSERT INTO system (name, value) VALUES ('installed', 1)";
        $querys[] = "INSERT INTO system (name, value) VALUES ('databaseVersion', 1)";

        foreach ($querys as $query){
            $sql->query($query);
            if($sql->error){
                die($sql->error);
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['firstAccount'])){
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $passwordConfirm = md5($_POST['passwordConfirm']);
            $address = $_POST['address'];
            $birthdate = $_POST['birthdate'];
            $createdAt = date('Y-m-d H:i:s');
            if($password !== $passwordConfirm){
                echo "Le password non corrispondono";
                echo "Fai click <a href='install.php?_Step=2'>qui</a> per ricreare l'account";
                die();
            }
            $sql->query("INSERT INTO users (name, surname, email, address, birthdate, password, createdAt) VALUES ('$name', '$surname', '$email', '$address', '$birthdate', '$password', '$createdAt')");
            if($sql->error){
                die($sql->error);
            }
            $sql->query("INSERT INTO userLevels (userID,levelID) VALUES (1,4)");
            if($sql->error){
                die($sql->error);
            }


            header("install.php?_Step=3");
        }
    }
    header("location: install.php");