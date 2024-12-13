<?php
session_start();

// Redirect if the user is not logged in or has the wrong role
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("location:login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

$data = mysqli_connect($host, $user, $password, $db);
if (!$data) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['add_course'])) {
    $course_id = mysqli_real_escape_string($data, $_POST['course_id']);
    $course_title = mysqli_real_escape_string($data, $_POST['course_title']);
    $credits = mysqli_real_escape_string($data, $_POST['credits']);

    // Check if Course ID already exists
    $check = "SELECT * FROM course WHERE course_id = '$course_id'";
    $check_id = mysqli_query($data, $check);

    if (mysqli_num_rows($check_id) > 0) {
        echo "<script>alert('Course ID already exists. Please try another.');</script>";
    } else {
        // Insert new course
        $sql = "INSERT INTO course (course_id, course_title, credits) VALUES ('$course_id', '$course_title', '$credits')";
        if (mysqli_query($data, $sql)) {
            echo "<script>alert('Course added successfully.'); window.location.href = 'view_course.php';</script>";
        } else {
            echo "<script>alert('Failed to add course: " . mysqli_error($data) . "');</script>";
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
    <title>Course Dashboard</title>
    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 200px;
            padding-top: 40px;
            padding-bottom: 30px;
        }

        .div_deg {
            background-color: skyblue;
            width: 1600px;
            height: 600px;
            padding-top: 60px;
            padding-bottom: 70px;
        }
    </style>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Add Course</h1>
            <div class="div_deg">
                <form action="" method="POST">
                    <div>
                        <label>Course ID</label>
                        <input type="number" name="course_id" required>
                    </div>
                    <div>
                        <label>Course Title</label>
                        <input type="text" name="course_title" required>
                    </div>
                    <div>
                        <label>Credits</label>
                        <input type="number" name="credits" required>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary" name="add_course" value="Add Course">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>