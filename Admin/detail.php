<?php 
session_start();


// Check if the session is still active
if (!isset($_SESSION['favanimal'])) {
// Redirect to a logout or login page
header("Location: adminLogin.php");
exit();
}


// Include the database connection file
require_once "../Database/dbconnection.php";

// Function to get the count of rows in a table
function getRowCount($conn, $table)
{
    $query = "SELECT COUNT(*) AS count FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Get the counts
$studentCount = getRowCount($conn, 'student');
$facultyCount = getRowCount($conn, 'faculty');
$classCount = getRowCount($conn, 'classes');
$notificationCount = getRowCount($conn, 'notice');
$subjectCount = getRowCount($conn, 'subjects');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.css" rel="Stylesheet">
    <link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.min.css" rel="Stylesheet">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
        }
        body {
            background-image: linear-gradient(to right, rgb(242, 112, 156), rgb(255, 148, 114));
        }

        .form-border {
            border: 0;
            border-bottom: 2px solid;
            background: transparent;
        }
        

        .navbar {
            background-color: midnightblue; 
        }

        .nav-link {
            padding: 8px 12px;
            border-radius: 5px;
            color:cyan;
        }

        .nav-link:hover {
            background-color: aqua; /* Set background color to aqua when hovering */
        }

        .nav-link.active {
            background-color: aqua;
            color: aqua;
        }

        .nav-link.active:hover {
            background-color: aqua; 
            color:white;/* Keep the color when hovering */
        }

        .nav-item.active .nav-link {
            font-weight: bold; /* Make the text bold for active link */
        }

        .logout-button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'admin.php') echo 'active'; ?>" href="admin.php">Verify faculties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'uploadfilenow.php') echo 'active'; ?>" href="uploadfilenow.php">Upload Docs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'notification.php') echo 'active'; ?>" href="notification.php">Add/Delete Notification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'detail.php') echo 'active'; ?>" href="detail.php">Stat</a>
                </li>
            </ul>
            <form action="adminLogin.php" method="" class="logout-button">
                <button type="submit" class="btn btn-danger" name="logout">Logout</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h4 style="color: midnightblue;">Student Count</h4>
                    <p class="display-4" style="color: midnightblue;"><?php echo $studentCount; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 style="color: midnightblue;">Faculty Count</h4>
                    <p class="display-4" style="color: midnightblue;"><?php echo $facultyCount; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 style="color: midnightblue;">Class Count</h4>
                    <p class="display-4" style="color: midnightblue;"><?php echo $classCount; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 style="color: midnightblue;">Notification Count</h4>
                    <p class="display-4" style="color: midnightblue;"><?php echo $notificationCount; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4 style="color: midnightblue;">Subject Count</h4>
                    <p class="display-4" style="color: midnightblue;"><?php echo $subjectCount; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
