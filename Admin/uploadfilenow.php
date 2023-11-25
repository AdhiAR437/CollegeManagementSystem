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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
    <h2 style="color: midnightblue;" class=" mt-4" >Upload files</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        // Check if a file is selected
        if ($_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
            $target_folder = $_POST["folder"];
            $target_path = $target_folder . '/' . basename($_FILES["fileToUpload"]["name"]);

            // Check if the folder exists, create it if not
            if (!is_dir($target_folder)) {
                mkdir($target_folder, 0755, true);
            }

            $file_extension = pathinfo($target_path, PATHINFO_EXTENSION);
            if ($file_extension !== "xlsx") {
                echo "Only Excel files (.xlsx) are allowed.";
            }
            
            else {

            // Check if the file already exists in the destination folder
            if (file_exists($target_path)) {
                // Overwrite the existing file
                if (unlink($target_path)) {
                    echo "The existing file has been overwritten.";
                } else {
                    echo "Failed to overwrite the existing file.";
                }
            }

            // Move the uploaded file to the target folder
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_path)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded and copied to " . $target_folder . ".";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        } else {
            echo "Please select a file to upload.";
        }

        
    }
    ?>
            </div>
        </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="upload_and_copy.php" method="post" enctype="multipart/form-data">
                    <label for="folder" class="form-label">Select a folder:</label>
                    <select class="form-select mb-3" name="folder" id="folder" required>
                        <option value="" selected disabled>Select an option</option>
                        <option value="Facultytimetable">Faculty Timetable</option>
                        <option value="Facultyschedule">Faculty Roles</option>
                        <option value="Timetables">Timetables</option>
                        <option value="Results">Results</option>
                        
                        <!-- Add more options as needed -->
                    </select>

                    <label for="fileToUpload" class="form-label">Select a file:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control mb-3" accept=".xlsx">

                    <input type="submit" value="Upload " name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
