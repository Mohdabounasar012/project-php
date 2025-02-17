<?php
mysqli_report(MYSQLI_REPORT_OFF);

# Database credentials
define("DB_SERVER", "database-1.ch2wm0wuekno.ap-northeast-1.rds.amazonaws.com");
define("DB_USERNAME", "admin");
define("DB_PASSWORD", "Abounasar");
define("DB_NAME", "mydb");

# Create connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check connection
if (!$link) {
  echo "Connection error: " . mysqli_connect_error();
}

# SQL to create the 'employees' table
$sql = "CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    role VARCHAR(50) NOT NULL,
    joining_date DATE NOT NULL,
    action VARCHAR(255) DEFAULT NULL
)";

# Execute the query to create table
if (mysqli_query($link, $sql)) {
    echo "Table 'employees' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($link);
}

# Prepare the INSERT query (after the table creation)
$insert_sql = "INSERT INTO employees (first_name, last_name, email, age, gender, role, joining_date, action) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

# Prepare statement
$stmt = mysqli_prepare($link, $insert_sql);

# Check if preparation was successful
if ($stmt) {
    # Bind parameters
    mysqli_stmt_bind_param($stmt, "sssiisss", $first_name, $last_name, $email, $age, $gender, $role, $joining_date, $action);
    
    # Set values to insert
    $first_name = 'John';
    $last_name = 'Doe';
    $email = 'john.doe@example.com';
    $age = 30;
    $gender = 'Male';
    $role = 'Manager';
    $joining_date = '2023-02-01';
    $action = 'Active';

    # Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "New record inserted successfully.";
    } else {
        echo "Error inserting record: " . mysqli_error($link);
    }

    # Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($link);
}

# Close the connection after all queries
mysqli_close($link);
?>
