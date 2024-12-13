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
if (isset($_POST['add_notification'])) {
    // Collect form data and escape it
    $student_id = mysqli_real_escape_string($data, $_POST['student_id']);
    $message = mysqli_real_escape_string($data, $_POST['message']);
    $notification_type = mysqli_real_escape_string($data, $_POST['notification_type']);
    $is_read = 0; // Default to unread
    $timestamp = date("Y-m-d H:i:s"); // Current timestamp

    // Insert the sanitized values directly into the database
    $sql = "INSERT INTO notifications (student_id, message, notification_type, is_read, timestamp) 
            VALUES ('$student_id', '$message', '$notification_type', '$is_read', '$timestamp')";

    $result = mysqli_query($data, $sql);

    if ($result) {
        echo "Notification added successfully.";
    } else {
        echo "Failed to add notification: " . mysqli_error($data);
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
    <title>Add Notification</title>
    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 120px;
            padding-top: 10px;
            padding-bottom: 30px;
        }

        .div_deg {
            background-color: skyblue;
            width: 800px;
            padding: 40px;
            margin-top: 20px;
            border-radius: 10px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Add Notification</h1>
            <div class="div_deg">
                <form action="#" method="POST">
                    <div>
                        <label>Student ID</label>
                        <input type="number" name="student_id" required>
                    </div>
                    <div>
                        <label>Message</label>
                        <textarea name="message" rows="4" required></textarea>
                    </div>
                    <div>
                        <label>Type</label>
                        <select name="notification_type" required>
                            <option value="Exam">Exam</option>
                            <option value="Result">Result</option>
                            <option value="Course">Course</option>
                            <option value="Message">Message</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" name="add_notification" value="Add Notification">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>

</html>