<?php
session_start();
if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>English Learning System</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <link rel="icon" href="assets/logo.png" type="image/png"
</head>
<body>
<div class="jumpotron-fluid">
    <img src="assets/banner.png" class="img-fluid" alt="">
</div>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top justify-content-center">
    <a class="navbar-brand" href="index.php"><img src="assets/logo.png" width="30" height="30" alt=""></a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="add_a_word.php">Add a word</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_words.php">Manage words</a>
        </li>
        <li class="nav-item">
            <?php
                if ($_SESSION['is_admin_logged_in']) {
                    echo "<a class='nav-link' href='add_an_user.php'>Add an user</a>";
                } else {
                    echo "<a class='nav-link' href='learn_a_word.php'>Learn a word</a>";
                }
            ?>
        </li>
            <?php
                if ($_SESSION['is_admin_logged_in']) {
                    echo "<li class='nav-item'><a class='nav-link' href='manage_users.php'>Manage users</a></li>";
                }
            ?>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Sign out</a>
        </li>
    </ul>
</nav>
<br>
<div class="container">
    <h1 class="display-4">Assignment 2 - Build a scalable app on Clouds</h1>
    <h1>Lecturer: Nguyen Ngoc Thanh</h1>
    <br>
    <p>Student name: Le Nguyen Anh Tuan</p>
    <p>Student ID: s3574983</p>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>