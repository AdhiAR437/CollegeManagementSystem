<?php 
    session_start();
    $_SESSION["favanimal"] = "cat";


// Check if the session is still active

    header("Location: Attendance.php");
    exit();


?>