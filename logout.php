<?php
    include "header.php";
    session_destroy();
    header("location: index.php");