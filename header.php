<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/stile.css">
<script type="text/javascript" src="js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<?php
    include 'config.php';
    @session_start();
    print_r($_SESSION);
    echo "<br><br>";

    function changeUserStatusToSuspended($sql, $userID){
        $sql->query("UPDATE userStatus SET statusID = 3 WHERE userID = '$userID'");
        if($sql->error){
            die($sql->error);
        }
    }

    $subscriptions = $sql->query("select * from subscriptions");
    if($subscriptions->num_rows>0){
        while ($subscription = $subscriptions->fetch_assoc()){
            $expiryDate = $subscription['expiryDate'];
            $expiryArray = explode('-', explode(' ', $expiryDate));
            $todayArray = explode('-', explode(' ', date('Y-m-d H:i:s'))[0]);
            if($expiryArray[0] >= $todayArray[0]){
                if($expiryArray[0] > $todayArray[0]){
                    changeUserStatusToSuspended($sql, $subscription['userID']);
                }else{
                    if($expiryArray[1] >= $todayArray[1]){
                        if($expiryArray[1] > $todayArray[1]){
                            changeUserStatusToSuspended($sql, $subscription['userID']);
                        }else{
                            if($expiryArray[2] > $todayArray[2]){
                                changeUserStatusToSuspended($sql, $subscription['userID']);
                            }
                        }
                    }
                }
            }
        }
    }