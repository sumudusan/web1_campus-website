<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nic = $conn->real_escape_string($_POST['nic']);
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $tel_no = $conn->real_escape_string($_POST['tel_no']);
    $course = $conn->real_escape_string($_POST['course']);

    $sql = "INSERT INTO students (nic, name, address, tel_no, course) VALUES ('$nic', '$name', '$address', '$tel_no', '$course')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
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
        <h2>Student Registration</h2>
        <form action="register.php" method="post">
            <label for="nic">NIC</label>
            <input type="text" name="nic" id="nic" required>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>

            <label for="address">Address</label>
            <input type="text" name="address" id="address" required>

            <label for="tel_no">Tel. No</label>
            <input type="text" name="tel_no" id="tel_no" required>

            <label for="course">Course</label>
            <input type="text" name="course" id="course" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
