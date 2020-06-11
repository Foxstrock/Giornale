<?php
    include "header.php";

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
            <input type="submit" value="invia">
        </form>
        <?php
    }elseif($_SERVER['REQUEST_METHOD']=='POST'){
        $title=$_POST['title'];
        $subtitle=$_POST['subtitle'];
        $text=$_POST['text'];
        $foto = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
        $tipoMimeFoto = mime_content_type($_FILES['foto']['tmp_name']);
        echo $foto.PHP_EOL;
        print_r($_POST);
        echo PHP_EOL;
        print_r($_FILES);
    }