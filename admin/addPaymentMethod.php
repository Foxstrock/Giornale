<?php
include "header.php";
if($_SESSION['user']['levelID']!=4){
    header("location: ../index.php");
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    ?>

    <form method="post" action="#">
        <input type="text" name="PaymentsMethod">
        <input type="submit" value="Invia">
    </form>

    <?php
}
elseif($_SERVER["REQUEST_METHOD"] == "POST"){

    $PayementMethods = $_POST['PaymentsMethod'];

    $sql->query("INSERT INTO paymentMethods (name) VALUES ('$PayementMethods')");

    header("location: managePaymentMethods.php");
}