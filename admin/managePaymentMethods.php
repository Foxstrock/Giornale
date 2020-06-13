<?php
    include "header.php";
    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if(!isset($_GET['action'])) {
        $paymentMethods = $sql->query("SELECT * FROM paymentMethods");
        echo "riga 8";
        while ($paymentMethod = $paymentMethods->fetch_assoc()) {
            $data .= "<td>" . $paymentMethod['name'] . "</td><td><a href='managePaymentMethods.php?action=delete&methodName=" . $paymentMethod['name'] . "'>Elimina</td>";
        }
    }elseif ($_GET['action'] == "delete"){
        $paymentMethodName=$_GET['methodName'];
        $sql->query("DELETE FROM paymentMethods WHERE name='$paymentMethodName'");
        header("location: managePaymentMethods.php");
    }