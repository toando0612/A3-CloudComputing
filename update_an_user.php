<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: index.php");
    }
}

$username_Err = $email_Err = $is_admin_Err = $password_Err = $confirm_password_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;
    if (empty($_POST["username"])) {
        $username_Err = "Username is required";
        $_SESSION['username'] = $_POST['username'];
    } else {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE username='".$_POST["username"]."'";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            $row = mysqli_fetch_assoc($data);
            if ($row['id'] == $_SESSION['id_update_user']) {
                $count += 1;
            } else {
                $username_Err = "Username already exists";
            }
        } else {
            $count += 1;
        }
        mysqli_close($conn);
        $_SESSION['username'] = $_POST['username'];
    }
    if (empty($_POST["email"])) {
        $email_Err = "Email is required";
        $_SESSION['email'] = $_POST['email'];
    } else {
        $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE email='".$_POST["email"]."'";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            $row = mysqli_fetch_assoc($data);
            if ($row['id'] == $_SESSION['id_update_user']) {
                $count += 1;
            } else {
                $email_Err = "Email already exists";
            }
        } else {
            $count += 1;
        }
        mysqli_close($conn);
        $_SESSION['email'] = $_POST['email'];
    }
    if (empty($_POST["is_admin"])) {
        $is_admin_Err = "Is admin are required";
        $_SESSION['is_admin'] = $_POST['is_admin'];
    } else {
        $count += 1;
        $_SESSION['is_admin'] = $_POST['is_admin'];
    }
    if (empty($_POST["password"])) {
        $password_Err = "Password is required";
        $_SESSION['password'] = $_POST['password'];
    } else {
        $count += 1;
        $_SESSION['password'] = $_POST['password'];
    }
    if (empty($_POST["confirm_password"])) {
        $confirm_password_Err = "Confirm password is required";
        $_SESSION['confirm_password'] = $_POST['confirm_password'];
    } else {
        if ($_POST["confirm_password"] != $_POST["password"]) {
            $confirm_password_Err = "Confirm password does not match";
        } else {
            $count += 1;
        }
        $count += 1;
        $_SESSION['confirm_password'] = $_POST['confirm_password'];
    }
    if ($count == 6) {
        $options = [
            'cost' => 12,
        ];
        $_SESSION['password'] = password_hash($_SESSION['password'], PASSWORD_BCRYPT, $options);
        unset($_SESSION["confirm_password"]);
        header("Location: actions/update_an_user_action.php");
    }
}
if($_GET['id'] != null) {
    $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM users WHERE id='".$_GET['id']."'";
    $data = mysqli_query($conn, $sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
        $_SESSION['id_update_user'] = $_GET['id'];
        $_SESSION["username"] = $_POST["username"] =  $row["username"];
        $_SESSION["email"] = $_POST["email"] = $row["email"];
        $_SESSION["is_admin"] = $_POST["is_admin"] = $row["is_admin"];
    }
    mysqli_close($conn);
} else {
    $_POST["username"] = $_SESSION["username"];
    $_POST["email"] = $_SESSION["email"];
    $_POST["is_admin"] = $_SESSION["is_admin"];
    $_POST["password"] = $_SESSION["password"];
    $_POST["confirm_password"] = $_SESSION["confirm_password"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update an User</title>
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
            <a class="nav-link" href="add_an_user.php">Add an user</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_users.php">Manage users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Sign out</a>
        </li>
    </ul>
</nav>
<br>
<div class="container-fluid">
    <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " method="post">
        <div class="form-group">
            <input placeholder="Username" class="form-control" type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
            <span class="error">* <?php echo $username_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Email" class="form-control" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
            <span class="error">* <?php echo $email_Err;?></span>
        </div>
        <div class="form-check">
            <input type="radio" name="is_admin" value="admin" <?php if ($_POST['is_admin']=="admin") {echo "checked";} ?> id="admin">
            <label for="admin">Admin</label>
            <input type="radio" name="is_admin" value="learner" <?php if ($_POST['is_admin']=="learner") {echo "checked";} ?> id="learner">
            <label for="learner">Learner</label>
            <span class="error">* <?php echo $is_admin_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Password" class="form-control" type="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
            <span class="error">* <?php echo $password_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Confirm password" class="form-control" type="password" name="confirm_password" value="<?php echo isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
            <span class="error">* <?php echo $confirm_password_Err;?></span>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>