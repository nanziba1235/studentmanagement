<?php
session_start();

if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin')) {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

$data = mysqli_connect($host, $user, $password, $db);
if (!$data) {
    die("Database connection failed: " . mysqli_connect_error());
}

$course_id = $_GET['id'];
$sql = "SELECT * FROM course WHERE course_id = '$course_id'";
$result = mysqli_query($data, $sql);
$course = mysqli_fetch_assoc($result);

if (isset($_POST['update_course'])) {
    $course_title = mysqli_real_escape_string($data, $_POST['course_title']);
    $credits = mysqli_real_escape_string($data, $_POST['credits']);

    $update_sql = "UPDATE course SET course_title = '$course_title', credits = '$credits' WHERE course_id = '$course_id'";
    if (mysqli_query($data, $update_sql)) {
        echo "<script>alert('Course updated successfully.'); window.location.href = 'view_course.php';</script>";
    } else {
        echo "<script>alert('Failed to update course: " . mysqli_error($data) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <h1>Update Course</h1>
        <div class="form-container">
            <form action="" method="POST">
                <label>Course Title</label>
                <input type="text" name="course_title" value="<?php echo htmlspecialchars($course['course_title']); ?>" required>
                <label>Credits</label>
                <input type="number" name="credits" value="<?php echo htmlspecialchars($course['credits']); ?>" required>
                <input type="submit" name="update_course" value="Update Course">
            </form>
        </div>
    </div>
</body>

</html>