<?php
// Function to handle login and validate user
function handleLogin()
{
    require_once "../Database/dbconnection.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];
        // Perform a query to check if the username and password match in the database
        $query = "SELECT * FROM student WHERE email='$username' AND password='$password' AND verification=1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Login successful, redirect to a welcome page or home page
            header("Location: log.php");
            exit();
        } else {
            // Login failed, show an error message
            echo '<script>alert("Invalid username or password.");</script>';

        }

        // Close the database connection
        mysqli_close($conn);
    }
}

// Call the function to handle the login
handleLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.css" rel="Stylesheet">
    <link href="../Bootstrap\bootstrap-5.3.0-dist\bootstrap-5.3.0-dist\css\bootstrap.min.css" rel="Stylesheet">
    <title>SignUp Form</title>
    <style>
        body {
            background-image: linear-gradient(to right, purple, rgb(255, 148, 114));
        }

        .form-border {
            border: 0;
            border-bottom: 2px solid;
            background: transparent;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-4">&nbsp;</div>
        <div class="col-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="card" style="width: 30rem;">
                <div class="card-body">
                    <p class="card-title text-center fs-2"><b>Student</b><br />login</p>
                    <br /><br />

                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text form-border" id="basic-addon1"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    </svg></span>
                                <input type="text" class="form-control form-border" placeholder="Enter Your First name"
                                    aria-label="Username" aria-describedby="basic-addon1" name="username" required >
                            </div>

                        </div>
                    </div><br />
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text form-border" id="basic-addon1"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z" />
                                    </svg></span>
                                <input type="password" class="form-control form-border"
                                    placeholder="Enter your Password" aria-label="Username"
                                    aria-describedby="basic-addon1" required name="password">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button class="btn btn-outline-success" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                                <a href="StudentSignUp.php" class="btn btn-outline-primary">Sign Up</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                                <a href="../index.php" class="btn btn-outline-primary">Home</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">&nbsp;</div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</body>

</html>