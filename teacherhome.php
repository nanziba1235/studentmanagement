<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'student') {
    header("location:login.php");
    exit();
} elseif ($_SESSION['role'] == 'admin') {
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-image: url('adminback.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 40px;
        }

        aside {
            width: 1000px;
            background-color: burlywood;
            height: 100vh;
            padding: 200px;
            position: fixed;
            top: 0;
            left: 0;
            color: black;
            font-size: 100px;
        }

        .teacher-profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .teacher-img {
            width: 450px;
            height: 450px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
        }

        .teacher-profile h3 {
            margin-top: 10px;
            font-size: 50px;
        }

        .teacher-profile p {
            font-size: 50px;
            margin-top: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li a {
            text-decoration: none;
            font-size: 50px;
            color: black;
            padding: 12px 15px;
            display: block;
            border-radius: 50px;
            margin-bottom: 40px;
            transition: background-color 0.3s;
        }

        ul li a:hover {
            background-color: wheat;
        }

        ul li a i {
            margin-right: 10px;
        }


        header {
            margin-left: 300px;
            background-color: black;
            padding: 20px;
            color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            right: 0;
            width: calc(100% - 300px);
            z-index: 1000;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
        }

        .logout a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }



        .content {
            padding: 20px;
            text-align: left;

            /* Semi-transparent background */
            font-size: 100px;
            margin-left: 500px;
        }

        .content h2 {
            color: white;
            font-size: 100px;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 60px;
            line-height: 1.6;
            color: white;
        }
    </style>
</head>

<body>
    <aside>
        <div class="teacher-profile">
            <img src="sir.jpg" alt="Teacher Picture" class="teacher-img">
            <h3>Rudra Pratap Deb Nath</h3>
            <p>rudra@gmail.com</p>
        </div>
        <ul>



            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="#"><i class="fas fa-book"></i> My Courses</a></li>
            <li><a href="#"><i class="fas fa-check-circle"></i> Create Session</a></li>


        </ul>
        <div class="logout">
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>

    </aside>


    <div class="content">
        <h2>Rudra Pratap Deb Nath</h2>
        <p>I'am a teacher of cse department.</p>
    </div>
</body>

</html>