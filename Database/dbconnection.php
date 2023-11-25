<?php
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = "yourpassword"; // Replace with your MySQL password
$database = "collegedb"; // Replace with your MySQL database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
    echo "Connection failed";
}

// Connection successful

?>