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
if ($data === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Fetch notifications from the database
$sql = "SELECT notification_id, student_id, message, notification_type, is_read, timestamp FROM notifications";
$result = mysqli_query($data, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notifications</title>
    <style type="text/css">
        .table_th {
            padding: 10px;
            font-size: 16px;
            background-color: #f2f2f2;
        }

        .table_td {
            padding: 10px;
            text-align: left;
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
    <?php include 'admin_css.php'; ?>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
            <h1>Notifications</h1>
            <br><br>
            <table border="1px">
                <tr>
                    <th class="table_th">Notification ID</th>
                    <th class="table_th">Student ID</th>
                    <th class="table_th">Message</th>
                    <th class="table_th">Type</th>
                    <th class="table_th">Status</th>
                    <th class="table_th">Timestamp</th>
                </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display each notification's details
                        echo "<tr>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['notification_id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['notification_type']) . "</td>";
                        echo "<td class='table_td'>" . ($row['is_read'] ? 'Read' : 'Unread') . "</td>";
                        echo "<td class='table_td'>" . htmlspecialchars($row['timestamp']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='table_td'>No notifications found.</td></tr>";
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