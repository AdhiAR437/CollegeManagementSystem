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
<html>
<head>
    <link href="../Bootstrap/bootstrap-5.3.0-dist/bootstrap-5.3.0-dist/css/bootstrap.css" rel="Stylesheet">
    <link href="../Bootstrap/bootstrap-5.3.0-dist/bootstrap-5.3.0-dist/css/bootstrap.min.css" rel="Stylesheet">
    <title>Student Attendance</title>
    <style>

        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        
        /* Style for the attendance percentage */
        .low-attendance {
            color: red;
        }
        .high-attendance {
            color: green;
        }
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
    <h2 style="color: midnightblue;">Student Attendance</h2
    >
    
    <form method="post">
        <label style="color: midnightblue;">Select Class: </label>
        <select name="class_id">
        <option value="no_class_selected">No class selected</option>
            <?php
            require_once('../Database/dbconnection.php'); // Include the database connection file
            
            // Fetch classes from the database
            $query = "SELECT class_id, class_name FROM Classes";
            $result = $conn->query($query);
            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
            }
            ?>
        </select>
        <input class="btn btn-primary" type="submit" name="view_attendance" value="View Attendance">
    </form>
    
    <?php
    if (isset($_POST['view_attendance']) && $_POST['class_id'] !== 'no_class_selected') {
        $class_id = $_POST['class_id'];
        
        // Fetch students for the selected class
        $students_query = "SELECT registration_number, CONCAT(fname, ' ', lname) AS student_name
                           FROM student
                           WHERE class_id = $class_id";
        $students_result = $conn->query($students_query);
        
        // Fetch subjects for the selected class
        $subjects_query = "SELECT subject_id, subject_name
                           FROM Subjects
                           WHERE class_id = $class_id
                           ";
        $subjects_result = $conn->query($subjects_query);
        
        if ($students_result->num_rows > 0 && $subjects_result->num_rows > 0) {
            echo "<h2 style='color: midnightblue;'>Attendance for Selected Class</h2>";
            echo "<table class='table table-bordered table-hover table-light table-striped table-bordered border border-info border border-4' style='background-color: #fff;'>
        <tr>
            <th>Registration number</th>
            <th>Student Name</th>";
            
            // Display subjects as table headers
            while ($subject_row = $subjects_result->fetch_assoc()) {
                echo "<th>" . $subject_row['subject_name'] . "</th>";
            }
            
            echo "</tr>";
            
            // Loop through students
            while ($student_row = $students_result->fetch_assoc()) {
                echo "<tr>
                        <td>" .$student_row['registration_number'] ."</td>
                        <td>" . $student_row['student_name'] . "</td>";
                
                // Loop through subjects
                $subjects_result->data_seek(0); // Reset subjects result pointer
                while ($subject_row = $subjects_result->fetch_assoc()) {
                    $subject_id = $subject_row['subject_id'];
                    
                    // Fetch attendance data for the current student and subject
                    $attendance_query = "SELECT COUNT(*) AS total_attendance
                                         FROM Attendance
                                         WHERE registration_number = '" . $student_row['registration_number'] . "'
                                         AND class_id = $class_id
                                         AND subject_id = $subject_id
                                         AND is_present = 1";
                    $attendance_result = $conn->query($attendance_query);
                    $attendance_data = $attendance_result->fetch_assoc();
                    
                    $total_attendance = isset($attendance_data['total_attendance']) ? $attendance_data['total_attendance'] : 0;
                    
                    // Fetch total lectures for the subject
                    $total_lectures_query = "SELECT COUNT(*) AS total_lectures
                                            FROM Attendance
                                            WHERE registration_number = '" . $student_row['registration_number'] . "'
                                            AND class_id = $class_id
                                            AND subject_id = $subject_id";
                    $total_lectures_result = $conn->query($total_lectures_query);
                    $total_lectures_data = $total_lectures_result->fetch_assoc();
                    
                    $total_possible_lectures = $total_lectures_data['total_lectures'];
                    
                    // Calculate attendance percentage if total_possible_lectures is greater than zero
                    if ($total_possible_lectures > 0) {
                        $attendance_percentage = ($total_attendance / $total_possible_lectures) * 100;
                    } else {
                        $attendance_percentage = 0; // Avoid division by zero
                    }
                    
                    $attendance_class = ($attendance_percentage < 75) ? 'low-attendance' : 'high-attendance';
                    
                    echo "<td class='$attendance_class'>" . number_format($attendance_percentage, 2) . "%</td>";
                }
        
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No attendance records found for the selected class.</p>";
        }
    }
    elseif (isset($_POST['view_attendance'])) {
        echo "<p>Select a valid class to view attendance.</p>";
    }
    ?>
</body>
</html>
