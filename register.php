<?php
session_start();

if ($_SESSION['is_logged_in']) {
    header("Location: index.php");
}

$username_register_Err = $email_register_Err = $password_Err = $confirm_password_register_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;
    if (empty($_POST["username_register"])) {
        $username_register_Err = "Username is required";
    } else {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE username='".$_POST["username_register"]."'";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            $username_register_Err = "Username already exists";
        } else {
            $count += 1;
        }
        mysqli_close($conn);
    }
    if (empty($_POST["email_register"])) {
        $email_register_Err = "Email is required";
    } else {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE email='".$_POST["email_register"]."'";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            $email_register_Err = "Email already exists";
        } else {
            $count += 1;
        }
        mysqli_close($conn);
    }
    if (empty($_POST["password_register"])) {
        $password_Err = "Password is required";
    } else {
        $count += 1;
    }
    if (empty($_POST["confirm_password_register"])) {
        $confirm_password_register_Err = "Confirm password is required";
    } else {
        if ($_POST["confirm_password_register"] != $_POST["password_register"]) {
            $confirm_password_register_Err = "Confirm password does not match";
        } else {
            $count += 1;
        }
        $count += 1;
    }
    if ($count == 5) {
        $_SESSION['username_register'] = $_POST['username_register'];
        $_SESSION['email_register'] = $_POST['email_register'];
        $options = [
            'cost' => 12,
        ];
        $_SESSION['password_register'] = password_hash($_POST['password_register'], PASSWORD_BCRYPT, $options);
        header("Location: actions/register_an_user_action.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add an User</title>
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

    <h1 class="display-4" align="center">Register</h1>
</div>
<div class="container-fluid">
    <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " method="post">
        <div class="form-group">
            <input placeholder="Username" class="form-control" type="text" name="username_register" value="<?php echo isset($_POST['username_register']) ? $_POST['username_register'] : '' ?>">
            <span class="error">* <?php echo $username_register_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Email" class="form-control" type="email" name="email_register" value="<?php echo isset($_POST['email_register']) ? $_POST['email_register'] : '' ?>">
            <span class="error">* <?php echo $email_register_Err;?></span>
        </div>

        <div class="form-group">
            <input placeholder="Password" class="form-control" type="password" name="password_register" value="<?php echo isset($_POST['password_register']) ? $_POST['password_register'] : '' ?>">
            <span class="error">* <?php echo $password_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Confirm Password" class="form-control" type="password" name="confirm_password_register" value="<?php echo isset($_POST['confirm_password_register']) ? $_POST['confirm_password_register'] : '' ?>">
            <span class="error">* <?php echo $confirm_password_register_Err?></span>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php">Login</a>
    </form>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>