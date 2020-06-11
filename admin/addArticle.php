<?php
    include "header.php";

    if($_SERVER['REQUEST_METHOD']=='GET'){
        ?>
        <form action="#addArticle" method="post">
            Titolo:
            <input type="text" name="title"><br>
            Sottotitolo:
            <input type="text" name="subtitle"><br>
            Testo:
            <input type="text" name="text"><br>
            Immagine:
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" id="uploadfile">
            <input name="userfile" type="file" >
            <br>
            <input type="submit" value="invia">
        </form>
        <?php
    }elseif($_SERVER['REQUEST_METHOD']=='POST'){
        $title=$_POST['title'];
        $subtitle=$_POST['subtitle'];
        $text=$_POST['text'];
        $file=
    }