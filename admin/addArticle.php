<?php
    include "header.php";
    if(!isset($_SESSION['user']['id'])){
        header("location: ../login.php");
    }
    if($_SERVER['REQUEST_METHOD']=='GET'){
        ?>
        <form action="#addArticle" method="post" enctype="multipart/form-data">
            Titolo:
            <input type="text" name="title"><br>
            Sottotitolo:
            <input type="text" name="subtitle"><br>
            Testo:
            <input type="text" name="text"><br>
            Immagine:
            <input type="file" name="foto" id="foto"><br>
            Categoria:
            <input type="number" name="category" id="category">
            <input type="submit" value="invia">
        </form>
        <?php
    }elseif($_SERVER['REQUEST_METHOD']=='POST'){
        $title=$_POST['title'];
        $subtitle=$_POST['subtitle'];
        $text=$_POST['text'];
        $createdBy = $_SESSION['user']['id'];
        $createdAt = date("Y-m-d H:i:s");
        $lastEdited = $createdAt;
        $lastEditedBy = $createdBy;
        $category = $_POST['category'];
        $foto = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
        $tipoMimeFoto = mime_content_type($_FILES['foto']['tmp_name']);


    }