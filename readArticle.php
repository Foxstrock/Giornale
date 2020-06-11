<?php
    include "header.php";
    if(!isset($_SESSION['user']['id'])){
        header("location: index.php");
    }
    if(!isset($_GET['articleID'])){
        $articles = $sql->query("SELECT * FROM articles");
        if($articles->num_rows==0){
            echo "Non ci sono articoli, mettiti a scrivere pezzo di merda sennò ti bocciano!";
        }else {
            echo "<table><tr><td>ID</td><td>Title</td><td>Photo</td><td>Category</td></tr>";
            while ($article = $articles->fetch_assoc()) {
                $articleID = $article['articleID'];
                $title = $article['title'];
                $attachment = $article['attachment'];
                $categoryID = $article['categoryID'];
                $tipoMimeFoto = $article['mimeType'];
                $categoryName = $sql->query("SELECT name FROM categories WHERE categoryID='$categoryID'");

                $data .= "<tr><td><a href='readArticle.php?articleID=$articleID'>$articleID</a></td><td>$title</td><td><img width='100' height='100' src='data: ".$tipoMimeFoto.";base64,".$attachment."'/></td><td>$categoryName</td></tr>";

            }
            echo $data;
            echo "</table>";
        }
    }else{
        $articleID = $_GET['articleID'];
    }