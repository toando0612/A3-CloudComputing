<?php
session_start();

if ($_SESSION['is_logged_in']) {
    header("Location: ../index.php");
} else {
    if (empty($_SESSION['username_register']) || empty($_SESSION['email_register']) || empty($_SESSION['password_register'])) {
        header("Location: ../register.php");
    } else {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO users (username, email, is_admin, password)
VALUES ('{$conn->real_escape_string($_SESSION['username_register'])}', '{$conn->real_escape_string($_SESSION['email_register'])}',
'learner', '{$conn->real_escape_string($_SESSION['password_register'])}')";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            unset($_SESSION['username_register']);
            unset($_SESSION['email_register']);
            unset($_SESSION['password_register']);
            header("Location: ../login.php");
        }
    }

}



