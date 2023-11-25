<?php

session_start();


// Check if the session is still active
if (!isset($_SESSION['favanimal'])) {
// Redirect to a logout or login page
header("Location: ../index.php");
exit();
}

// Include your database connection file
require_once '../Database/dbconnection.php';

// Delete notice if delete button is clicked
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM notice WHERE id = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Insert new notice if form is submitted
if(isset($_POST['submit'])) {
    $new_notice = $_POST['new_notice'];
    $sql_insert = "INSERT INTO notice (notice_content) VALUES ('$new_notice')";
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

// Fetch notices from the table
$sql_fetch = "SELECT id,date, notice_content FROM notice";
$result = $conn->query($sql_fetch);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notice Board</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="../Bootstrap/bootstrap-5.3.0-dist/bootstrap-5.3.0-dist/css/bootstrap.min.css">
    <style>
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
        .smaller-cell {
        width: 123px; /* Adjust the width as needed */
    }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'studentveri.php') echo 'active'; ?>" href="studentveri.php">Verify Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'timetable.php') echo 'active'; ?>" href="timetable.php">Time-Table</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'Roles.php') echo 'active'; ?>" href="Roles.php">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'notification.php') echo 'active'; ?>" href="notification.php">Notification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'Attendance.php') echo 'active'; ?>" href="Attendance.php">Attendance</a>
                </li>
            </ul>
            <form action="../index.php" method="post" class="logout-button">
                <button type="submit" class="btn btn-danger" name="logout">Logout</button>
            </form>
        </div>
    </nav>

        <h1 style="color: midnightblue;">Notice Board</h1>
        
        <!-- Display existing notices -->
        <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-hover table-light table-striped table-bordered border border-info border border-4" style="background-color: #fff;">
            <tr>
                <th>Date</th>
                <th>Notice</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="smaller-cell"><?php echo $row['date']; ?></td>
                <td><?php echo formatNotice($row['notice_content']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p>No notices available.</p>
        <?php endif; ?>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>

<?php
// Function to format notice content
function formatNotice($content) {
    $words = explode(' ', $content);
    $formatted = '';

    $line = '';
    $wordCount = 0;
    
    foreach ($words as $word) {
        if ($wordCount >= 7) {
            $formatted .= $line . '<br>';
            $line = '';
            $wordCount = 0;
        }
        $line .= ($line ? ' ' : '') . $word;
        $wordCount++;
    }
    
    $formatted .= $line;
    
    return $formatted;
}
?>
