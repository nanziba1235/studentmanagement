<?php
session_start();

// Redirect if the user is not logged in or is not a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("location:login.php");
    exit();
}

// Check if student id is set in the session
if (!isset($_SESSION['id'])) {
    die("Student ID is not set in the session.");
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

// Fetch notifications for the student using the 'id' field
$student_id = $_SESSION['id']; // Use id from session
$sql = "SELECT n.id, n.message, n.status, n.created_at, c.course_title
        FROM notifications n
        INNER JOIN course c ON n.course_id = c.course_id
        WHERE n.student_id = $student_id
        ORDER BY n.created_at DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching notifications: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Notifications</title>
    <?php include 'student_css.php'; ?>
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

        .notification-item {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .unread {
            background-color: #f8f9fa;
            border-left: 4px solid #ffcc00;
            /* Yellow border for unread notifications */
        }

        .read {
            background-color: #e9ecef;
            border-left: 4px solid #28a745;
            /* Green border for read notifications */
        }
    </style>
</head>

<body>
    <?php include 'student_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Student Notifications</h1>
            <table>
                <tr>
                    <th class="table_th">Notification ID</th>
                    <th class="table_th">Course Title</th>
                    <th class="table_th">Message</th>
                    <th class="table_th">Status</th>
                    <th class="table_th">Date</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Set status class (unread or read)
                        $status_class = $row['status'] == 'unread' ? 'unread' : 'read';

                        echo "<tr class='$status_class'>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['course_title']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='table_td'>No notifications found.</td></tr>";
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