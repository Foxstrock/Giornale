<?php
    include "header.php";
    if($_SESSION['user']['levelID']!=4){
        header("location: ../index.php");
    }
    if ($_SERVER['REQUEST_METHOD']=="GET"){
        $users = $sql->query("SELECT * FROM users");
        while($user = $users->fetch_assoc()){
            $userSelect .= "<option name='userID_".$user['userID']."'>".$user['name']." ".$user['surname']." - ".$user['email']."</option>";
        }


        $paymentMethods = $sql->query("SELECT * FROM paymentMethods");
        while ($paymentMethod = $paymentMethods->fetch_assoc()){
            $paymentMethodSelect .= "<option name='paymentMethodID_".$paymentMethod['paymentMethodsID']."'>".$paymentMethod['name']."</option>";
        }
        ?>
        <form action="#" method="POST">
            Utente:
            <select id="user" name="user">
                <?php echo $userSelect; ?>
            </select><br>
            Scadenza abbonamento:
            <input type="date" name="expirationDate"><br>
            Metodo di pagemento:
            <select id="paymentMethod" name="paymentMethod">
                <?php echo $paymentMethodSelect; ?>
            </select><br>
            <input type="submit" name="submit" value="Inserisci">
        </form>
        <?php
    }else{
        $currentDate = date('Y-m-d H:i:s');
        $expiryDate = $_POST['expirationDate'];
        $user = $_POST['user'];
        $paymentMethod = $_POST['paymentMethod'];
        $expiryDate = $expiryDate.' 23:59:59';
        $paymentMethodID = $sql->query("SELECT * FROM paymentMethods WHERE name='$paymentMethod'")->fetch_array()['paymentMethodID'];
        $userEmail = explode('-', $user)[1];
        $userEmail = trim($userEmail);
        $userID = $sql->query("SELECT * FROM users WHERE email = '$userEmail'")->fetch_array()['userID'];
        $sql->query("INSERT INTO subscriptions (userID,subscriptionDate,exiprationDate,paymentMethodID) VALUES ('$userID','$currentDate','$expiryDate','$paymentMethodID')");
        header("location: manageSubscriptions.php");
    }