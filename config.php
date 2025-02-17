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
