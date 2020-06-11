<?php
    include "header.php";
    if($_SERVER['REQUEST_METHOD']=="GET"){
        ?>

        <form method="post" action="#">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" placeholder="Category Name">
            <input type="submit" name="create" id="create" value="Create!">
        </form>

        <?php
    }elseif ($_SERVER['REQUEST_METHOD']=="POST"){
        $categoryName = $_POST['name'];
        $sql->query("INSERT INTO categories (name) VALUES ('$categoryName')");
        if($sql->error){
            die($sql->error);
        }
        header("location: viewCategories.php");
    }
?>

