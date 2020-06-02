<?php
/**
* Workflow
* check installato in tabella sistema e versione -> inizio -> check ambiente -> creazione tabelle -> popolazione tabelle -> creazione primo utente -> configurazione base -> popolazione record installato e versione db
*/
    include "config.php";
    $dbVersion = 1;

    //Initialize querys variable
    $querys=[];

    //check if installed and db version
    $installed = $sql->query("SELECT * FROM system WHERE name = 'installed'");
    if($installed->num_rows >= 1){
        $dbInstalledVersion = $sql->query("SELECT * FROM system WHERE name = 'dbVersion'");
        $dbInstalledVersion = $dbInstalledVersion->fetch_array()['value'];
        if($dbInstalledVersion = $dbVersion){
            die("Already installed and up to date");
        }
    }else{
        //Install 1.0
        //Status table
        $querys[] = "CREATE TABLE status (statusID int NOT NULL PRIMARY KEY, name varchar(200) NOT NULL, active tinyint NOT NULL) Engine=InnoDB";
        //userStatus table
        $querys[] = "CREATE TABLE userStatus (statusID int NOT NULL, userID int NOT NULL) Engine=InnoDB";
        //Levels table
        $querys[] = "CREATE TABLE levels (levelID int NOT NULL PRIMARY KEY, name varchar(200) NOT NULL, subscriber tinyint NOT NULL, subscriber editor NOT NULL, subscriber director NOT NULL) Engine=InnoDB";
        //userLevels table
        $querys[] = "CREATE TABLE userLevels (levelID int NOT NULL, userID int NOT NULL) Engine=InnoDB";
        //System Table
        $querys[] = "CREATE TABLE system (settingID int NOT NULL PRIMARY KEY, name varchar(200) NOT NULL, value longtext NOT NULL) Engine=InnoDB";
        //Categories Table
        $querys[] = "CREATE TABLE categories (categoryID int NOT NULL PRIMARY KEY, name varchar(200) NOT NULL) Engine=InnoDB";
        //Articles Table
        $querys[] = "CREATE TABLE articles (articleID int NOT NULL PRIMARY KEY,title longtext NOT NULL,subtitle longtext NOT NULL,text longtext NOT NULL,attachment longtext NOT NULL,createdAt datetime NOT NULL,creatorID int NOT NULL,lastEditorID int NOT NULL,lastEdited datetime NOT NULL,categoryID int NOT NULL) Engine=InnoDB";

        foreach ($querys as $query) {

        }

    }