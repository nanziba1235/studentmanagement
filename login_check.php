<?php

error_reporting(0);
session_start();


$host = "localhost";

$user = "root";

$password = "";

$db = "studentproject";


$data = mysqli_connect($host, $user, $password, $db);


if ($data === false) {
    die("connection error");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];

    $pass = $_POST['password'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM user WHERE username='" . $name . "' AND password='" . $pass . "' AND email='" . $email . "'";


    $result = mysqli_query($data, $sql);

    $row = mysqli_fetch_array($result);



    if ($row["role"] == "student") {

        $_SESSION['username'] = $name;

        $_SESSION['role'] = "student";
        $_SESSION['id'] = $row['id'];
        header("location:studenthome.php");
    } elseif ($row["role"] == "admin") {
        $_SESSION['username'] = $name;

        $_SESSION['role'] = "admin";

        header("location:adminhome.php");
    } elseif ($row["role"] == "teacher") {
        $_SESSION['username'] = $name;

        $_SESSION['role'] = "teacher";

        header("location:teacherhome.php");
    } else {


        $message = "username or password do not match";

        $_SESSION['loginMessage'] = $message;

        header("location:login.php");
    }
}
