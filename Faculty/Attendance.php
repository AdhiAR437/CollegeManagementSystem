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
    <title>Lecturer Attendance</title>
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
        .button-container {
    margin-top: 10px; /* Add margin to create space between elements */
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
    <h2 style='color: midnightblue;'>Lecturer Attendance Facility</h2>
    
    <?php
    require_once('../Database/dbconnection.php'); // Include the database connection file
    
    if (!isset($_POST['class_id']) && !isset($_POST['load_subjects']) && !isset($_POST['load_students'])) {
        // Initial load or no class selected
        echo "<form method='post'>";
        echo "<label style='color: midnightblue;'>Select Class: </label>";
        echo "<select name='class_id'>";
        echo "<option value='hhm'>Select Class</option>";
        
        // Fetch classes from the database
        $query = "SELECT class_id, class_name FROM Classes";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
        }
        
        echo "</select>";
        echo "<div class='button-container'>";
        echo "<input type='submit'class='btn btn-primary' name='load_subjects' value='Load Subjects'>";
        echo "</div>";
        echo "</form>";
    } else if (isset($_POST['load_subjects'])) {
        // Class selected, load subjects
        $class_id = $_POST['class_id'];

        if ($class_id === 'hhm') {
            echo "<script>alert('Please select valid class'); window.location.href = 'Attendance.php';</script>";
            exit;}
        
        echo "<form method='post'>";
        echo "<label style='color: midnightblue;'>Select Class: </label>";
        echo "<select name='class_id'>";
        echo "<option value='hhm'>Select Class</option>";

        
        // Fetch classes from the database
        $query = "SELECT class_id, class_name FROM Classes";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $selected = ($row['class_id'] == $class_id) ? 'selected' : '';
            echo "<option value='" . $row['class_id'] . "' $selected>" . $row['class_name'] . "</option>";
        }
        
        echo "</select>";
        echo "<div class='button-container'>";
        echo "<input type='submit' name='load_subjects' value='Load Subjects' class='btn btn-primary'>";
        echo "</div>";
        echo "</form>";
        
        // Fetch subjects for the selected class
        $subjects_query = "SELECT subject_id, subject_name
                           FROM Subjects
                           WHERE class_id = $class_id";
        $subjects_result = $conn->query($subjects_query);
        
        echo "<form method='post'>";
        echo "<label style='color: midnightblue;'>Select Subject: </label>";
        echo "<select name='subject_id'>";
        echo "<option value='hhm'>Select Subject</option>";
        
        while ($subject_row = $subjects_result->fetch_assoc()) {
            echo "<option value='" . $subject_row['subject_id'] . "'>" . $subject_row['subject_name'] . "</option>";
        }
        
        echo "</select>";
        echo "<div class='button-container'>";
        echo "<input type='hidden' name='class_id' value='$class_id'>";
        echo "<input class='btn btn-primary' type='submit' name='load_students' value='Load Students'>";
        echo "</div>";
        echo "</form>";
    } else if (isset($_POST['load_students'])) {
        // Subjects selected, load students
        $class_id = $_POST['class_id'];
        $subject_id = $_POST['subject_id'];
        if ($class_id === 'hhm' || $subject_id === 'hhm') {
            echo "<script>alert('Please select valid subject or class'); window.location.href = 'Attendance.php';</script>";
            exit;}
        echo "<form method='post'>";
        echo "<label style='color: midnightblue;'>Select Class: </label>";
        echo "<select name='class_id'>";
        echo "<option value='hhm'>Select Class</option>";
        
        // Fetch classes from the database
        $query = "SELECT class_id, class_name FROM Classes";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $selected = ($row['class_id'] == $class_id) ? 'selected' : '';
            echo "<option value='" . $row['class_id'] . "' $selected>" . $row['class_name'] . "</option>";
        }
        
        echo "</select>";
        echo "<div class='button-container'>";
        echo "<input type='submit' name='load_subjects' value='Load Subjects'class='btn btn-primary'>";
        echo "</div>";
        echo "</form>";
        
        // Fetch subjects for the selected class
        $subjects_query = "SELECT subject_id, subject_name
                           FROM Subjects
                           WHERE class_id = $class_id";
        $subjects_result = $conn->query($subjects_query);
        
        echo "<form method='post'>";
        echo "<label style='color: midnightblue;'>Select Subject: </label>";
        echo "<select name='subject_id'>";
        echo "<option value='hhm'>Select Subject</option>";

        
        while ($subject_row = $subjects_result->fetch_assoc()) {
            $selected = ($subject_row['subject_id'] == $subject_id) ? 'selected' : '';
            echo "<option value='" . $subject_row['subject_id'] . "' $selected>" . $subject_row['subject_name'] . "</option>";
        }
        
        echo "</select>";
        echo "<div class='button-container'>";
        echo "<input type='hidden' name='class_id' value='$class_id'>";
        echo "<input type='submit' name='load_students' value='Load Students' class='btn btn-primary'>";
        echo "</div>";
        echo "</form>";
        
        // Fetch students for the selected class
        $students_query = "SELECT registration_number, CONCAT(fname, ' ', lname) AS student_name
                           FROM student
                           WHERE class_id = $class_id";
        $students_result = $conn->query($students_query);
        
        echo "<form method='post'>";
        echo "<h2 style='color: midnightblue;'>Mark Attendance</h2>";
        echo "<table class='table table-bordered table-hover table-light table-striped table-bordered border border-info border border-4' style='background-color: #fff;'>
                <tr>
                    <th>Student Name</th>
                    <th>Registration Number</th>
                    <th>Attendance</th>
                </tr>";
        
        while ($student_row = $students_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $student_row['student_name'] . "</td>
                    <td>" .$student_row['registration_number'] . "</td>
                    <td><input type='checkbox' name='attendance[]' value='" . $student_row['registration_number'] . "'></td>
                </tr>";
        }
        
        echo "</table>";
        echo "<input type='hidden' name='class_id' value='$class_id'>";
        echo "<input type='hidden' name='subject_id' value='$subject_id'>";
        echo "<input type='submit' name='submit_attendance' value='Submit Attendance' class='btn btn-primary'>";
        echo "</form>";
    }
    
    if (isset($_POST['submit_attendance'])) {
        $subject_id = $_POST['subject_id'];
        $class_id = $_POST['class_id'];
        $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];
    
        // Fetch students for the selected class
        $students_query = "SELECT registration_number
                           FROM student
                           WHERE class_id = $class_id";
        $students_result = $conn->query($students_query);
        $students_present = [];
    
        while ($student_row = $students_result->fetch_assoc()) {
            $student_reg = $student_row['registration_number'];
            $is_present = in_array($student_reg, $attendance) ? 1 : 0;
    
            $insert_query = "INSERT INTO Attendance (registration_number, class_id, subject_id, semester, attendance_date, is_present)
                             VALUES ('$student_reg', $class_id, $subject_id, 1, NOW(), $is_present)";
            $conn->query($insert_query);
        }
    
        echo "<p style='color: midnightblue;'>Attendance has been marked and saved.</p>";
    }
    
    
    ?>
</body>
</html>
