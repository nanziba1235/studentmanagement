<?php
session_start();

// Redirect if the user is not logged in or is not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $db);

if ($conn === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Check if the student ID is passed in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Check if student exists in the database
    $check_student = "SELECT * FROM student WHERE id = '$student_id'";
    $result = mysqli_query($conn, $check_student);

    if (mysqli_num_rows($result) > 0) {
        // Delete student record from the database
        $delete_query = "DELETE FROM student WHERE id = '$student_id'";

        if (mysqli_query($conn, $delete_query)) {
            $_SESSION['message'] = "Student deleted successfully!";
            header("location:view_student.php"); // Redirect to the students page
            exit();
        } else {
            echo "<script>alert('Failed to delete student: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Student not found');</script>";
    }
}

mysqli_close($conn);
