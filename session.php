<?php

    session_start();



    echo $_SESSION['username'];

    if($_SESSION['email']) {
        
        echo "Your are logged in.";
        
    }else {
        
        header("location: index.php");
        
    }

?>