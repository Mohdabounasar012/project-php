<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
  <title>PHP CRUD Operations</title>
</head>

<body>
  <div class="container">
    <div class="py-4">
      <a href="./create.php" class="btn btn-secondary">
        <i class="bi bi-plus-circle-fill"></i> Add Employee
      </a>
    </div>

    <!-- Table starts here -->
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Role</th>
          <th>Joining Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Open connection
        require_once "./config.php";

        // Query to select employees
        $sql = "SELECT * FROM employees";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $count = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $count++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['joining_date']) . "</td>";
                    echo "<td><a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> 
                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                    echo "</tr>";
                }
                mysqli_free_result($result);
            } else {
                echo "<tr><td colspan='9'>No records found.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Error fetching records: " . mysqli_error($link) . "</td></tr>";
        }

        // Close the connection after everything is done
        mysqli_close($link);
        ?>
      </tbody>
    </table>
  </div>

  <script>
    const delBtnEl = document.querySelectorAll(".btn-danger");
    delBtnEl.forEach(function(delBtn) {
      delBtn.addEventListener("click", function(e) {
        const message = confirm("Are you sure you want to delete this record?");
        if (message == false) {
          e.preventDefault();
        }
      });
    });
  </script>
</body>

</html>
