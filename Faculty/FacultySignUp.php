<?php
// Include the database connection file
require_once "../Database/dbconnection.php";

// Function to handle form submission and insert data into the database
function handleRegistration($conn)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $rollNumber = $_POST['rollnumber'];
        $branch=$_POST['branch'];
        $designation=$_POST['designation'];

        // Perform the database query to insert data
        $query = "INSERT INTO faculty (fname, lname, email, phoneno, password, facultynumber, branch, designation) 
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$password', '$rollNumber', '$branch', '$designation')";

        try {if (mysqli_query($conn, $query)) {
            // Data insertion successful
            echo '<script>alert("Registration successful.");</script>';
        } }
        catch(mysqli_sql_exception $ttt){
            // Error occurred while inserting data
            //echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
            echo '<script>alert("The faculty number or email id provided is already registered please use different one and try again.");</script>';
        }
    }
}

// Call the function to handle form submission and data insertion
handleRegistration($conn);
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
        
    </style>
</head>
<body>
    <div class="row"><div class="col-12">&nbsp;</div></div>
    <div class="row"><div class="col-12">&nbsp;</div></div>
    <div class="row"><div class="col-12">&nbsp;</div></div>
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-text">
                        <p class="fs-4 fw-medium">Faculty Registration Form</p>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="Firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-label form-control border-dark" style="--bs-border-opacity: .5;" id="Firstname" name="firstname" required>
                            </div>
                            <div class="col-6">
                                <label for="Lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-label form-control  border-dark" style="--bs-border-opacity: .5;" id="Lastname" name="lastname" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" class="form-label form-control border-dark" style="--bs-border-opacity: .5;" id="Email" name="email" required>
                            </div>
                            <div class="col-6">
                                <label for="PhoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" pattern="^[6-9]\d{9}$" title="Please Enter the valid Phone Number" class="form-label form-control border-dark" style="--bs-border-opacity: .5;" id="PhoneNumber" name="phone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" class="form-label form-control border-dark" style="--bs-border-opacity: .5;" id="Password" name="password" required>
                            </div>
                            <div class="col-6">
                                <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-label form-control border-dark" style="--bs-border-opacity: .5;" id="ConfirmPassword" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="RollNumber" class="form-label">Faculty Id Number</label>
                                <input type="text" id="RollNumbe0r" class="form-label form-control border-dark dropdown-toggle" style="--bs-border-opacity: .5;" name="rollnumber" required>
                            </div>
                            <div class="col-6">
                                <label for="BranchSelect" class="form-label">Select Branch</label>
                                <select class="form-select form-control border-dark" style="--bs-border-opacity: .5;" id="BranchSelect" name="branch" required>
                                    <option value="" selected disabled>Select a Branch</option>
                                    <option value="BCA">BCA</option>
                                    <option value="MCA">MCA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="DesignationSelect" class="form-label">Select Designation</label>
                                <select class="form-select form-control border-dark" style="--bs-border-opacity: .5;" id="DesignationSelect" name="designation" required>
                                    <option value="" selected disabled>Select a Designation</option>
                                    <option value="Assistant Professor">Assistant Professor</option>
                                    <option value="HOD">HOD</option>
                                    <option value="Dean">Dean</option>
                                    <option value="Assistant Dean">Assistant Dean</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert" id="passwordMismatchAlert" style="display: none;">
                                    Passwords do not match!
                                </div>
                                <button class="btn btn-outline-success" type="submit" name="submit">Sign In</button>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="StudentLogIn.php" class="link link-dark text-decoration-none">Already Have an account ..? Please click here to login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for password validation -->
    <script>
        function validateForm() {
            var password = document.getElementById("Password").value;
            var confirmPassword = document.getElementById("ConfirmPassword").value;

            if (password !== confirmPassword) {
                document.getElementById("passwordMismatchAlert").style.display = "block";
                return false;
            }
        }
    </script>
</body>
</html>
