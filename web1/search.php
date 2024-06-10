<?php
include 'db.php';

// Handle update operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nic = $conn->real_escape_string($_POST['nic']);
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $tel_no = $conn->real_escape_string($_POST['tel_no']);
    $course = $conn->real_escape_string($_POST['course']);

    $sql = "UPDATE students SET name='$name', address='$address', tel_no='$tel_no', course='$course' WHERE nic='$nic'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record updated successfully";
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Handle delete operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $nic = $conn->real_escape_string($_POST['nic']);

    $sql = "DELETE FROM students WHERE nic='$nic'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

// Handle search operation
$search_result = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nic'])) {
    $nic = $conn->real_escape_string($_GET['nic']);

    $sql = "SELECT * FROM students WHERE nic='$nic'";
    $search_result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update this record?");
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Campus Website</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="search.php">Search</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Search Student</h2>
        <form action="search.php" method="get">
            <label for="nic">NIC</label>
            <input type="text" name="nic" id="nic" required>
            <input type="submit" value="Search">
        </form>

        <div id="results">
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }

            if ($search_result && $search_result->num_rows > 0) {
                while($row = $search_result->fetch_assoc()) {
                    echo "<form action='search.php' method='post' onsubmit='return confirmUpdate();'>
                            <input type='hidden' name='nic' value='" . $row["nic"] . "'>
                            <label for='name'>Name</label>
                            <input type='text' name='name' value='" . $row["name"] . "' required>
                            <label for='address'>Address</label>
                            <input type='text' name='address' value='" . $row["address"] . "' required>
                            <label for='tel_no'>Tel No</label>
                            <input type='text' name='tel_no' value='" . $row["tel_no"] . "' required>
                            <label for='course'>Course</label>
                            <input type='text' name='course' value='" . $row["course"] . "' required>
                            <input type='submit' name='update' value='Update'>
                          </form>
                          <form action='search.php' method='post' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='nic' value='" . $row["nic"] . "'>
                            <input type='submit' name='delete' value='Delete'>
                          </form>";
                }
            } else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nic'])) {
                echo "Results not found";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
