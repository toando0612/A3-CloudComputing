<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: ../login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: ../index.php");
    } else {
        if (empty($_SESSION['id_update_word'])) {
            header("Location: ../manage_words.php");
        } else {
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "UPDATE words SET word = '{$conn->real_escape_string($_SESSION['word'])}', 
vietnamese_meaning = '{$conn->real_escape_string($_SESSION['vietnamese_meaning'])}', 
similar_words = '{$conn->real_escape_string($_SESSION['similar_words'])}', example_one = '{$conn->real_escape_string($_SESSION['example_one'])}', 
example_two = '{$conn->real_escape_string($_SESSION['example_two'])}' WHERE id='".$_SESSION['id_update_word']."'";

            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                unset($_SESSION['id_update_word']);
                unset($_SESSION['word']);
                unset($_SESSION['vietnamese_meaning']);
                unset($_SESSION['similar_words']);
                unset($_SESSION['example_one']);
                unset($_SESSION['example_two']);
                header("Location: ../manage_words.php");
            }
        }

    }
}

