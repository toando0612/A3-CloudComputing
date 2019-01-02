<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: ../login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: ../index.php");
    } else {
        if (empty($_SESSION['id_update_user'])) {
            header("Location: ../manage_users.php");
        } else {
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "UPDATE users SET username = '{$conn->real_escape_string($_SESSION['username'])}', email = '{$conn->real_escape_string($_SESSION['email'])}', 
is_admin = '{$conn->real_escape_string($_SESSION['is_admin'])}', password = '{$conn->real_escape_string($_SESSION['password'])}' WHERE id='".$_SESSION['id_update_user']."'";

            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                unset($_SESSION['id_update_user']);
                unset($_SESSION['username']);
                unset($_SESSION['email']);
                unset($_SESSION['is_admin']);
                unset($_SESSION['password']);
                header("Location: ../manage_users.php");
            }
        }
    }
}


