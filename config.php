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

# Execute the query
if (mysqli_query($link, $sql)) {
    echo "Table 'employees' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($link);
}

# Close the connection
mysqli_close($link);
?>
