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
            </select>
            Scadenza abbonamento:
            <input type="date" name="expirationDate">
            Metodo di pagemento:
            <select id="paymentMethod" name="paymentMethod">
                <?php echo $paymentMethodSelect; ?>
            </select>
            <input type="submit" name="submit" value="Inserisci">
        </form>
        <?php
    }else{
        $currentDate = date('Y-m-d H:i:s');
        $expiryDate = $_POST['expirationDate'];
        $user = $_POST['user'];
        $paymentMethod = $_POST['paymentMethod'];
        print_r($_POST);
    }