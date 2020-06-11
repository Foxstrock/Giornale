<?php
    include "header.php";
    if($_SESSION['user']['levelID'] < 3){
        header("location: ../index.php");
    }
    if (isset($_GET['articleID'])){
        $articleID = $_GET['articleID'];
        $sql->query("DELETE FROM articles WHERE articleID = '$articleID'");
        if($sql->error){
            die($sql->error);
        }
        header("location: ../readArticle.php");
    }
