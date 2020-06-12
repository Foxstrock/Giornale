<?php
    include "header.php";
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="ml-0">
                <h2>Barcellona P.G. News</h2>
            </div>
            <div class="mr-0">
                <?php
                    if (session_status() == PHP_SESSION_ACTIVE) {
                        echo " <a href=\"logout.php\">Logout</a>";
                    }else {
                        echo "<a href=\"login.php\">Login</a>";
                    }
                ?>
                |
                <a href="signup.php">Sign Up</a>
            </div>
            </div>
        </div>
    </div>
</body>
