<?php
// Include database connection
require_once "./config.php";

// Define variables and initialize with empty values
$fname_err = $lname_err = $email_err = $age_err = $gender_err = $designation_err = $date_err = "";
$fname = $lname = $email = $age = $gender = $designation = $date = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check for first name
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "This field is required.";
    } else {
        $fname = ucfirst(trim($_POST["fname"]));
        if (!ctype_alpha($fname)) {
            $fname_err = "Invalid name format.";
        }
    }

    // Check for last name
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "This field is required.";
    } else {
        $lname = ucfirst(trim($_POST["lname"]));
        if (!ctype_alpha($lname)) {
            $lname_err = "Invalid name format.";
        }
    }

    // Check for email
    if (empty(trim($_POST["email"]))) {
        $email_err = "This field is required.";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email address.";
        } else {
            // Check if email already exists
            $email_check_query = "SELECT id FROM employees WHERE email = ?";
            if ($stmt = mysqli_prepare($link, $email_check_query)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $email_err = "This email is already taken.";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    // Check for age
    if (empty(trim($_POST["age"]))) {
        $age_err = "This field is required.";
    } else {
        $age = trim($_POST["age"]);
        if (!ctype_digit($age)) {
            $age_err = "Please enter a valid age number.";
        }
    }

    // Check for gender
    if (empty($_POST["gender"])) {
        $gender_err = "This field is required.";
    } else {
        $gender = $_POST["gender"];
    }

    // Check for designation
    if (empty($_POST["designation"])) {
        $designation_err = "This field is required.";
    } else {
        $designation = $_POST["designation"];
    }

    // Check for joining date
    if (empty($_POST["date"])) {
        $date_err = "This field is required";
    } else {
        $date = $_POST["date"];
    }

    // If there are no input errors, proceed with insertion
    if (empty($fname_err) && empty($lname_err) && empty($email_err) && empty($age_err) && empty($gender_err) && empty($designation_err) && empty($date_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO employees (first_name, last_name, email, age, gender, designation, joining_date) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisss", $param_fname, $param_lname, $param_email, $param_age, $param_gender, $param_designation, $param_date);

            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_age = $age;
            $param_gender = $gender;
            $param_designation = $designation;
            $param_date = $date;

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('New record created successfully.'); window.location.href='./';</script>";
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close the connection after everything is done (move this to the bottom of the script)
    mysqli_close($link);
}
?>

<!-- HTML Form to add a new employee -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
        <span class="invalid-feedback"><?php echo $fname_err; ?></span>
    </div>
    
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
        <span class="invalid-feedback"><?php echo $lname_err; ?></span>
    </div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
        <span class="invalid-feedback"><?php echo $email_err; ?></span>
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="number" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
        <span class="invalid-feedback"><?php echo $age_err; ?></span>
    </div>

    <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>">
            <option value="">Select Gender</option>
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>
        <span class="invalid-feedback"><?php echo $gender_err; ?></span>
    </div>

    <div class="form-group">
        <label for="designation">Role</label>
        <input type="text" name="designation" class="form-control <?php echo (!empty($designation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $designation; ?>">
        <span class="invalid-feedback"><?php echo $designation_err; ?></span>
    </div>

    <div class="form-group">
        <label for="date">Joining Date</label>
        <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
        <span class="invalid-feedback"><?php echo $date_err; ?></span>
    </div>

    <input type="submit" class="btn btn-primary" value="Add Employee">
</form>
