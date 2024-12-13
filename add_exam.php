<?php
session_start();

// Redirect if the user is not logged in or is not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add exam record
if (isset($_POST['add_exam'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $exam_type = mysqli_real_escape_string($conn, $_POST['exam_type']);
    $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa']);

    // Validate CGPA
    if ($cgpa < 0 || $cgpa > 4.00) {
        echo "<script>alert('Enter a valid CGPA between 0.00 and 4.00');</script>";
    } else {
        $sql = "INSERT INTO exam (student_id, exam_type, cgpa) VALUES ('$student_id', '$exam_type', '$cgpa')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Exam added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add exam: " . mysqli_error($conn) . "');</script>";
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exam</title>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Add Exam</h1>
            <form action="" method="POST">
                <label>Student ID:</label>
                <input type="number" name="student_id" required><br>
                <label>Exam Type:</label>
                <input type="text" name="exam_type" required><br>
                <label>CGPA:</label>
                <input type="number" step="0.01" name="cgpa" required><br>
                <button type="submit" name="add_exam">Add Exam</button>
            </form>
        </center>
    </div>
</body>

</html>