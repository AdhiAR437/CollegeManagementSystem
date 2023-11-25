<?php 
    session_start();
    $_SESSION["name"] = "adhi";


// Check if the session is still active

    header("Location: admin.php");
    exit();


?>