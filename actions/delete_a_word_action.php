<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: ../login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: ../index.php");
    } else {
        if (empty($_GET['id'])) {
            header("Location: ../manage_words.php");
        } else {
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "DELETE FROM words WHERE id='".$_GET['id']."'";
            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                header("Location: ../manage_words.php");
            }
        }
    }
}