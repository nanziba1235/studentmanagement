<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'admin') {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'teacher') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

// Connect to the database
$data = mysqli_connect($host, $user, $password, $db);
if ($data->connect_error) {
    die("Connection failed: " . $data->connect_error);
}

// Get student ID from URL
$id = $_GET['id']; // Ensure $id is an integer to prevent injection

// Fetch student data from the database
$sql = "SELECT * FROM student WHERE id = '$id'";
$result = mysqli_query($data, $sql);
$info = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    // Get the updated values from the form
    $name = mysqli_real_escape_string($data, $_POST['name']);
    $email = mysqli_real_escape_string($data, $_POST['email']);
    $session = mysqli_real_escape_string($data, $_POST['session']);
    $contact = mysqli_real_escape_string($data, $_POST['contact']);
    $semester = mysqli_real_escape_string($data, $_POST['semester']);
    $address = mysqli_real_escape_string($data, $_POST['address']);

    // Update student in the database
    $query = "UPDATE student SET name='$name', email='$email', session='$session', contact='$contact', semester='$semester', address='$address' WHERE id='$id'";
    $result2 = mysqli_query($data, $query);

    if ($result2) {
        echo "<script>alert('Update successful'); window.location.href='view_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating student');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <?php include 'student_css.php'; ?>
    <style>
        label {
            display: inline-block;
            width: 100px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg {
            background-color: skyblue;
            width: 400px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
    </style>
</head>

<body>
    <?php include 'student_sidebar.php'; ?>
    <div class="content">
        <center>
            <br><br>
            <h1>Update Student</h1>
            <div class="div_deg">
                <form action="" method="POST">
                    <div>
                        <label>Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($info['name']); ?>" required>
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($info['email']); ?>" required>
                    </div>
                    <div>
                        <label>Session</label>
                        <input type="text" name="session" value="<?php echo htmlspecialchars($info['session']); ?>" required>
                    </div>
                    <div>
                        <label>Contact</label>
                        <input type="text" name="contact" value="<?php echo htmlspecialchars($info['contact']); ?>" required>
                    </div>
                    <div>
                        <label>Semester</label>
                        <input type="text" name="semester" value="<?php echo htmlspecialchars($info['semester']); ?>" required>
                    </div>
                    <div>
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($info['address']); ?>" required>
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>