<?php
    include "header.php";
    if(!isset($_SESSION['user']['id'])){
        header("location: index.php");
    }
    if(!isset($_GET['articleID'])){
        $articles = $sql->query("SELECT * FROM articles");
        while ($article = $articles->fetch_assoc()){
            $articleID = $article['articleID'];
            $title = $article['title'];
            $subtitle = $article['subtitle'];
            $text = $article['text'];
            $attachment = $article['attachment'];
            $createdAt = $article['createdAt'];
            $creatorID = $article['creatorID'];
            $lastEditorID = $article['lastEditorID'];
            $lastEdited = $article['lastEdited'];
            $categoryID = $article['categoryID'];
            $categoryName = $sql->query("SELECT name FROM categories WHERE categoryID='$categoryID'");

            print_r($article);

        }

    }else{
        $articleID = $_GET['articleID'];
    }