<?php
session_start();
session_unset();
session_destroy();
// Check if the form is submitted and get the selected login type
if (isset($_POST['loginType'])) {
    $loginType = $_POST['loginType'];
    
    // Redirect to the respective login page
    if ($loginType === 'student') {
        header("Location: Student/StudentLogin.php");
        exit();
    } elseif ($loginType === 'faculty') {
        header("Location: Faculty/FacultyLogin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="Bootstrap/bootstrap-5.3.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.css" rel="Stylesheet">
    <link href="Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.min.css" rel="Stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Login</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(to right, rgb(242, 112, 156), rgb(255, 148, 114));
        }

        .container {
            max-width: 500px; /* Increased max-width for a bigger card */
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header {
            font-size: 48px; /* Bigger header font size */
            font-weight: 700;
            margin-bottom: 30px;
            color: #007BFF;
            text-decoration: underline;
        }

        .card {
            border: 1px solid #007BFF; /* Border added */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Increased box-shadow effect */
            padding: 50px; /* Increased padding for a longer card */
            border-radius: 20px;
            background-color: #ffffff;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2); /* Stronger box-shadow on hover */
        }

        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
            width: 100%;
            margin-bottom: 15px; /* Increased vertical spacing */
            border-radius: 10px;
            color: #fff;
            font-size: 24px; /* Slightly smaller font size */
            font-weight: 700;
            padding: 15px 30px;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card text-center">
            <div class="header text-center">CAMPUSWISE</div>
            <div class="header text-center  ">College Login</div>
            <form method="post">
                <button type="submit" class="btn btn-outline-primary btn-lg" name="loginType" value="student">Student Login</button>
            </form>
            <br>
            <form method="post">
                <button type="submit" class="btn btn-outline-primary btn-lg" name="loginType" value="faculty">Faculty Login</button>
            </form>
        </div>
    </div>
</body>
</html>
