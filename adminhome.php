<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'student') {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'teacher') {
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin_css.php">


    <?php
    include 'admin_css.php';
    ?>

</head>

<body>
    <?php

    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <br><br>
            <h1>Admin Dashboard</h1>



    </div>
    </center>
</body>

</html>