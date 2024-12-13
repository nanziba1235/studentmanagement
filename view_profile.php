<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'teacher') {
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

// Fetch all students
$sql = "SELECT * FROM student";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <?php include 'student_css.php'; ?>
    <style type="text/css">
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
</head>

<body>
    <?php include 'student_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Student Data</h1>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>
            <br><br>
            <table border="1px">
                <tr>
                    <th class="table_th">ID</th>
                    <th class="table_th">Name</th>
                    <th class="table_th">Email</th>
                    <th class="table_th">Session</th>
                    <th class="table_th">Contact</th>
                    <th class="table_th">Semester</th>
                    <th class="table_th">Address</th>

                    <th class="table_th">Update</th>
                </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($info = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['name']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['email']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['session']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['contact']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['semester']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($info['address']) . "</td>";

                        echo "<td class='table_td'><a class='update_btn' href='stu_update.php?id=" . $info['id'] . "'>Update</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='table_td'>No students found.</td></tr>";
                }
                ?>
            </table>
        </center>
    </div>
</body>

</html>