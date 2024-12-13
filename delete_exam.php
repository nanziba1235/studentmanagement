<?php
session_start();

// Redirect if not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "studentproject";

// Connect to the database
$data = mysqli_connect($host, $user, $password, $db);
if ($data === false) {
    die("Error connecting to the database.");
}

$id = $_GET['id'];

// Delete the exam record
$delete_sql = "DELETE FROM exam WHERE id = '$id'";

if (mysqli_query($data, $delete_sql)) {
    echo "<script>alert('Record deleted successfully.'); window.location.href = 'view_exam.php';</script>";
} else {
    echo "<script>alert('Error deleting record: " . mysqli_error($data) . "');</script>";
}

mysqli_close($data);
