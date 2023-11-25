<?php
session_start();


// Check if the session is still active
if (!isset($_SESSION['favanimal'])) {
// Redirect to a logout or login page
header("Location: adminLogin.php");
exit();
}

require_once "../Database/dbconnection.php";

// Function to handle accept/delete actions
function handleActions()
{
    global $conn;

    if (isset($_POST['accept'])) {
        // Handle accept action
        $id = $_POST['accept'];
        // Update the verification field to 1
        $query = "UPDATE faculty SET verification = 1 WHERE email = '$id'";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['delete'])) {
        // Handle delete action
        $id = $_POST['delete'];
        // Delete the entry from both temp and faculty tables
        $queryFaculty = "DELETE FROM faculty WHERE email = '$id'";
        mysqli_query($conn, $queryFaculty);
    }
}

// Call the function to handle accept/delete actions
handleActions();

// Fetch all rows from the table
$query = "SELECT * FROM faculty WHERE verification=0";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.css" rel="Stylesheet">
    <link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.min.css" rel="Stylesheet">
    <title>SignUp Form</title>
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
    <table  class="table table-bordered table-hover table-light table-striped table-bordered border border-info border border-4" style="background-color: #fff;">
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="table-light">
                <td class="table-warning"><?php echo $row['fname']; ?></td>
                <td class="table-warning"><?php echo $row['lname']; ?></td>
                <td class="table-warning"><?php echo $row['email']; ?></td>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <button type="submit" name="accept" value="<?php echo $row['email']; ?>" class="btn btn-success">Accept</button>
                        <button type="submit" name="delete" value="<?php echo $row['email']; ?>" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
