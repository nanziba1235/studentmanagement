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

// Fetch exam records with student details
$sql = "SELECT exam.id, exam.student_id, exam.exam_type, exam.cgpa, student.name AS student_name, student.email AS student_email 
        FROM exam 
        INNER JOIN student ON exam.student_id = student.id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exam Data</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .table_th {
            padding: 20px;
            font-size: 20px;
            text-align: center;
        }

        .table_td {
            padding: 20px;
            text-align: center;
            background-color: skyblue;
        }

        .content {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>View Exam Records</h1>
            <table>
                <tr>
                    <th class="table_th">Exam ID</th>
                    <th class="table_th">Student ID</th>
                    <th class="table_th">Student Name</th>
                    <th class="table_th">Student Email</th>
                    <th class="table_th">Exam Type</th>
                    <th class="table_th">CGPA</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_name']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_email']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['exam_type']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['cgpa']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='table_td'>No exam records found.</td></tr>";
                }
                ?>
            </table>
        </center>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>