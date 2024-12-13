<?php
session_start();

// Redirect if the user is not logged in or has the wrong role
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

// Connect to the database
$data = mysqli_connect($host, $user, $password, $db);
if ($data == false) {
    die("Connection error");
}

// Check if the form is submitted
if (isset($_POST['add_student'])) {
    // Collect form data and escape it
    $stu_id = mysqli_real_escape_string($data, $_POST['id']);
    $stu_name = mysqli_real_escape_string($data, $_POST['name']);
    $stu_email = mysqli_real_escape_string($data, $_POST['email']);
    $stu_session = mysqli_real_escape_string($data, $_POST['session']);
    $stu_contact = mysqli_real_escape_string($data, $_POST['contact']);
    $stu_semester = mysqli_real_escape_string($data, $_POST['semester']);
    $stu_address = mysqli_real_escape_string($data, $_POST['address']);

    // Check if student ID already exists
    $check = "SELECT * FROM student WHERE id = '$stu_id'";
    $check_id = mysqli_query($data, $check);
    $row_count = mysqli_num_rows($check_id);

    if ($row_count == 1) {
        echo "User ID already exists. Please try another.";
    } else {
        // Insert the sanitized values directly into the database
        $sql = "INSERT INTO student (id, name, email, session, contact, semester, address) 
                VALUES ('$stu_id', '$stu_name', '$stu_email', '$stu_session', '$stu_contact', '$stu_semester', '$stu_address')";

        $result = mysqli_query($data, $sql);

        if ($result) {
            echo "Student added successfully.";
        } else {
            echo "Failed to add student: " . mysqli_error($data);
        }
    }
}

// Close the database connection
mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 30px;
        }

        .div_deg {
            background-color: skyblue;
            width: 2000px;
            padding-top: 40px;
            padding-bottom: 60px;
        }
    </style>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Add Student</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>ID</label>
                        <input type="number" name="id" required>
                    </div>
                    <div>
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div>
                        <label>Session</label>
                        <input type="text" name="session" required>
                    </div>
                    <div>
                        <label>Contact</label>
                        <input type="number" name="contact" required>
                    </div>
                    <div>
                        <label>Semester</label>
                        <input type="text" name="semester" required>
                    </div>
                    <div>
                        <label>Address</label>
                        <input type="text" name="address" required>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary" name="add_student" value="Add Student">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>