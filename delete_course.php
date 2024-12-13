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

$sql = "DELETE FROM course WHERE course_id = '$course_id'";
if (mysqli_query($data, $sql)) {
    echo "<script>alert('Course deleted successfully.'); window.location.href = 'view_course.php';</script>";
} else {
    echo "<script>alert('Failed to delete course: " . mysqli_error($data) . "');</script>";
}

mysqli_close($data);
