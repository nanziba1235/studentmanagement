<?php
session_start();

// Redirect if the user is not logged in or has the wrong role
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'student')) {
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

// Fetch all courses
$sql = "SELECT * FROM course";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
        .table_th {
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table_td {
            padding: 10px;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-update {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
        }
    </style>
    <?php include 'student_css.php'; ?>
</head>

<body>
    <?php include 'student_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>View Courses</h1>
            <table border="1">
                <tr>
                    <th class="table_th">Course ID</th>
                    <th class="table_th">Course Title</th>
                    <th class="table_th">Credits</th>

                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="table_td"><?php echo $row['course_id']; ?></td>
                        <td class="table_td"><?php echo $row['course_title']; ?></td>
                        <td class="table_td"><?php echo $row['credits']; ?></td>

                    </tr>
                <?php } ?>
            </table>
        </center>
    </div>
</body>

</html>