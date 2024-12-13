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

$data = mysqli_connect($host, $user, $password, $db);
if (!$data) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all students for the attendance form
$sql = "SELECT * FROM student"; // Assuming you have 'id' as primary key
$students = mysqli_query($data, $sql);

if (isset($_POST['mark_attendance'])) {
    $student_id = mysqli_real_escape_string($data, $_POST['student_id']);
    $date = mysqli_real_escape_string($data, $_POST['date']);
    $status = mysqli_real_escape_string($data, $_POST['status']);

    // Check if attendance already marked for the given student and date
    $check = "SELECT * FROM attendance WHERE student_id = '$student_id' AND date = '$date'";
    $check_result = mysqli_query($data, $check);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Attendance already marked for this student on this date.');</script>";
    } else {
        // Insert attendance
        $sql = "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')";
        if (mysqli_query($data, $sql)) {
            echo "<script>alert('Attendance marked successfully.'); window.location.href = 'attendance.php';</script>";
        } else {
            echo "<script>alert('Failed to mark attendance: " . mysqli_error($data) . "');</script>";
        }
    }
}

mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <style>
        label {
            display: inline-block;
            text-align: right;
            width: 100px;

            padding-top: 10px;
            padding-bottom: 10px;
        }

        .form-container {
            background-color: skyblue;
            width: 900px;
            height: 400px;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
        }
    </style>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Mark Attendance</h1>
            <div class="form-container">
                <form action="attendance.php" method="POST">
                    <div>
                        <label>Student</label>
                        <select name="student_id" required>
                            <option value="">Select Student</option>
                            <?php while ($student = mysqli_fetch_assoc($students)) { ?>
                                <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label>Date</label>
                        <input type="date" name="date" required>
                    </div>

                    <div>
                        <label>Status</label>
                        <select name="status" required>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>

                    <div>
                        <input type="submit" name="mark_attendance" value="Mark Attendance">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>