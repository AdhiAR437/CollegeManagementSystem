<?php 
    session_start();
    

// Check if the session is still active
if (!isset($_SESSION['favanimal'])) {
    // Redirect to a logout or login page
    header("Location: ../index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../Bootstrap/bootstrap-5.3.0-dist/bootstrap-5.3.0-dist/css/bootstrap.css" rel="Stylesheet">
    <link href="../Bootstrap/bootstrap-5.3.0-dist/bootstrap-5.3.0-dist/css/bootstrap.min.css" rel="Stylesheet">
    <meta charset="UTF-8">
    <style>
        body {
            background-image: linear-gradient(to right, rgb(242, 112, 156), rgb(255, 148, 114));
        }
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        .error {
            color: red;
            font-weight: bold;
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
            background-color: aqua;
        }

        .nav-link.active {
            background-color: aqua;
            color: aqua;
        }

        .nav-link.active:hover {
            background-color: aqua;
            color: white;
        }

        .nav-item.active .nav-link {
            font-weight: bold;
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
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'Attendance.php') echo 'active'; ?>" href="Attendance.php">Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'testtable.php') echo 'active'; ?>" href="testtable.php">Timetable</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'iamarks.php') echo 'active'; ?>" href="iamarks.php">Results</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) === 'notification.php') echo 'active'; ?>" href="notification.php">Notification</a>
                </li>
            </ul>
            <form action="../index.php" method="post" class="logout-button">
                <button type="submit" class="btn btn-danger" name="logout">Logout</button>
            </form>
        </div>
    </nav>
<form method="post">
    <div class="form-group">
        <label for="filename" class="col-form-label">Select Class:</label>
        <select class="form-select" name="filename" id="filename" required>
            <option value="" selected>Select An Class</option>
            <?php
            // Get a list of files from the Timetables directory
            $timetablesDir = __DIR__ . '/../Admin/Timetables';
            $files = array_diff(scandir($timetablesDir), array('..', '.'));

            foreach ($files as $file) {
                // Display only the file name without the extension
                $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
                echo '<option value="' . $file . '">' . $fileNameWithoutExtension . '</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Load Time Table</button>
</form>

<?php
// Include the PhpSpreadsheet library
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to load the Excel file
function loadExcelFile($filename)
{
    // Path to the Excel file
    $excelFile = __DIR__ . '/../Admin/Timetables/' . $filename;

    // Check if the file exists
    if (!file_exists($excelFile)) {
        return null; // File not found, return null
    }

    // Load the Excel file
    $spreadsheet = IOFactory::load($excelFile);

    // Select the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest row and column indexes
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();

    // Convert the highest column index to a numeric value
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    // Initialize an empty array to store the fetched values
    $data = array();

    // Loop through each row and column to fetch the values
    for ($row = 1; $row <= $highestRow; $row++) {
        for ($column = 1; $column <= $highestColumnIndex; $column++) {
            // Get the cell value
            $cellValue = $worksheet->getCellByColumnAndRow($column, $row)->getValue();

            // Store the cell value in the data array
            $data[$row][$column] = $cellValue;
        }
    }

    return $data;
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the selected filename from the combo box
    $selectedFile = $_POST['filename'];

    // Load the Excel file using the custom function
    $data = loadExcelFile($selectedFile);
}

?>

<?php if (isset($errorMessage)): ?>
    <p class="error"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<?php if (isset($data)): ?>
    <table class="table table-bordered table-hover table-light table-striped table-bordered border border-info border border-4" style="background-color: #fff;">
        <?php foreach ($data as $row): ?>
        <tr>
            <?php foreach ($row as $cellValue): ?>
            <td><?php echo $cellValue; ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>
