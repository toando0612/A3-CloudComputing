<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: ../login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: ../index.php");
    } else {
        if (empty($_SESSION['username']) || empty($_SESSION['email']) || empty($_SESSION['is_admin']) || empty($_SESSION['password'])) {
            header("Location: ../add_an_user.php");
        } else {
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO users (username, email, is_admin, password)
VALUES ('{$conn->real_escape_string($_SESSION['username'])}', '{$conn->real_escape_string($_SESSION['email'])}',
'{$conn->real_escape_string($_SESSION['is_admin'])}', '{$conn->real_escape_string($_SESSION['password'])}')";

            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                unset($_SESSION['username']);
                unset($_SESSION['email']);
                unset($_SESSION['is_admin']);
                unset($_SESSION['password']);
                header("Location: ../manage_users.php");
            }
        }
    }
}



