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

$sql = "SELECT * FROM exam WHERE id = '$id'";
$result = mysqli_query($data, $sql);
$exam = mysqli_fetch_assoc($result);

if (isset($_POST['update_marks'])) {
    $marks = mysqli_real_escape_string($data, $_POST['marks']);

    // Update the exam mark
    $update_sql = "UPDATE exam SET marks = '$marks' WHERE id = '$id'";

    if (mysqli_query($data, $update_sql)) {
        echo "<script>alert('Marks updated successfully.'); window.location.href = 'view_exam.php';</script>";
    } else {
        echo "<script>alert('Error updating marks: " . mysqli_error($data) . "');</script>";
    }
}

mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Exam Marks</title>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Update Exam Marks</h1>
            <form action="update_exam.php?id=<?php echo $exam['id']; ?>" method="POST">
                <div>
                    <label>Marks</label>
                    <input type="number" name="marks" value="<?php echo $exam['marks']; ?>" required>
                </div>
                <div>
                    <input type="submit" name="update_marks" value="Update Marks">
                </div>
            </form>
        </center>
    </div>
</body>

</html>