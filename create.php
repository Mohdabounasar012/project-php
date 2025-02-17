<?php
# Include connection
require_once "./config.php";

# Define variables and initialize with empty values
$fname_err = $lname_err = $email_err = $age_err = $gender_err = $role_err = $date_err = "";
$fname = $lname = $email = $age = $gender = $role = $date = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "This field is required.";
    } else {
        $fname = ucfirst(trim($_POST["fname"]));
        if (!ctype_alpha($fname)) {
            $fname_err = "Invalid name format.";
        }
    }

    // Validate last name
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "This field is required.";
    } else {
        $lname = ucfirst(trim($_POST["lname"]));
        if (!ctype_alpha($lname)) {
            $lname_err = "Invalid name format.";
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "This field is required.";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email address.";
        } else {
            // Check if email already exists
            $checkEmailQuery = "SELECT COUNT(*) FROM employees WHERE email = '$email'";
            $checkResult = mysqli_query($link, $checkEmailQuery);
            $row = mysqli_fetch_row($checkResult);

            if ($row[0] > 0) {
                $email_err = "Email is already in use!";
            }
        }
    }

    // Validate age
    if (empty(trim($_POST["age"]))) {
        $age_err = "This field is required.";
    } else {
        $age = trim($_POST["age"]);
        if (!ctype_digit($age)) {
            $age_err = "Please enter a valid age number.";
        }
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $gender_err = "This field is required.";
    } else {
        $gender = $_POST["gender"];
    }

    // Validate role
    if (empty($_POST["role"])) {
        $role_err = "This field is required.";
    } else {
        $role = $_POST["role"];
    }

    // Validate joining date
    if (empty($_POST["date"])) {
        $date_err = "This field is required.";
    } else {
        $date = $_POST["date"];
    }

    // If there are no input errors, proceed with insertion
    if (empty($fname_err) && empty($lname_err) && empty($email_err) && empty($age_err) && empty($gender_err) && empty($role_err) && empty($date_err)) {

        // Proceed with the INSERT operation
        $insertQuery = "INSERT INTO employees (first_name, last_name, email, age, gender, role, joining_date, action) 
                        VALUES ('$fname', '$lname', '$email', '$age', '$gender', '$role', '$date', 'Active')";
        
        if (mysqli_query($link, $insertQuery)) {
            echo "Record inserted successfully!";
            // Redirect to index or other page if needed
            // header("Location: ./");
        } else {
            echo "Error inserting record: " . mysqli_error($link);
        }
    }
}

# Close connection
mysqli_close($link);
?>
