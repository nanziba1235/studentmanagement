<?php
session_start();

// Redirect if the user is not logged in or is not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
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
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Fetch attendance records from the database
$sql = "SELECT a.id AS attendance_id, a.date, a.status, s.name AS student_name, s.id AS student_id
        FROM attendance a
        JOIN student s ON a.student_id = s.id";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <style type="text/css">
        label {
            display: inline-block;
            text-align: right;
            width: 100px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .div_deg {
            background-color: skyblue;
            width: 800px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .table_th {
            padding: 20px;
            font-size: 20px;
        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
        }

        .delete_btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .update_btn {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete_btn:hover,
        .update_btn:hover {
            opacity: 0.8;
        }
    </style>
    <?php include 'student_css.php'; ?>
</head>

<body>
    <?php include 'student_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Attendance Records</h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>
            <br><br>
            <table border="1px">
                <tr>
                    <th class="table_th">Attendance ID</th>
                    <th class="table_th">Student Name</th>
                    <th class="table_th">Student ID</th>
                    <th class="table_th">Date</th>
                    <th class="table_th">Status</th>

                </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['attendance_id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_name']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['status']) . "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='table_td'>No attendance records found.</td></tr>";
                }
                ?>
            </table>
        </center>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($data);
?>