<?php 
    session_start();
    $_SESSION["favanimal"] = "cat";


// Check if the session is still active
if (!isset($_SESSION['favanimal'])) {
    // Redirect to a logout or login page
    header("Location: ../index.php");
    exit();
}


?>