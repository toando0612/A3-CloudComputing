<?php
session_start();

if ($_SESSION['is_logged_in']) {
    header("Location: index.php");
}

$username_login_Err = $password_login_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;
    if (empty($_POST["username_login"])) {
        $username_login_Err = "Please enter username";
    } else {
        $count += 1;
    }

    if (empty($_POST["password_login"])) {
        $password_login_Err = "Please enter password";
    } else {
        $count += 1;
    }

    if ($count == 2) {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE username='".$conn->real_escape_string($_POST['username_login'])."'";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            $row = mysqli_fetch_assoc($data);
            if (password_verify ($_POST["password_login"],  $row["password"])) {
                $_SESSION['is_logged_in'] = true;

                if ($row["is_admin"] == "admin") {
                    $_SESSION['is_admin_logged_in'] = true;
                } else {
                    $_SESSION['is_admin_logged_in'] = false;
                }
                mysqli_close($conn);
                header("Location: index.php");
            } else {
                $username_login_Err = "Invalid username or password";
                $password_login_Err = "Invalid username or password";
            }
        } else {
            $username_login_Err = "Invalid username or password";
            $password_login_Err = "Invalid username or password";
        }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>English Learning System - Login</title>
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

<br>
<div class="container">

<h1 class="display-4" align="center">English Learning System</h1>
</div>
<div class="container-fluid">
    <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " method="post">
        <div class="form-group">
            <input placeholder="Username" class="form-control" type="text" name="username_login" value="<?php echo isset($_POST['username_login']) ? $_POST['username_login'] : '' ?>">
            <span class="error">* <?php echo $username_login_Err;?></span>
        </div>

        <div class="form-group">
            <input placeholder="Password" class="form-control" type="password" name="password_login" value="<?php echo isset($_POST['password_login']) ? $_POST['password_login'] : '' ?>">
            <span class="error">* <?php echo $password_login_Err;?></span>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php">Register</a>
    </form>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>
