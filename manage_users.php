<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
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
<?php require 'navBar.php'?>
<br>
<div class="container text-dark">
    <h2>Users</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Is admin</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM users";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            while($row = mysqli_fetch_assoc($data)) {
                $id = $row["id"];
                $username = $row["username"];
                $email = $row["email"];
                $is_admin = $row["is_admin"];
                echo "<tr>";
                echo "<td>$username</td>";
                echo "<td>$email</td>";
                echo "<td>$is_admin</td>";
                echo "<td><a type='button' class='btn btn-warning text-dark' href='update_an_user.php?id=$id'>Update</a><a type='button' class='btn btn-danger text-dark' href='actions/delete_an_user_action.php?id=$id'>Delete</a></td>";
                echo "</tr>";
            }
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>