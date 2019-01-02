<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
} else {
    if (!$_SESSION['is_admin_logged_in']) {
        header("Location: index.php");
    }
}

$word_Err = $vietnamese_meaning_Err = $similar_words_Err = $example_one_Err = $example_two_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;
    if (empty($_POST["word"])) {
        $word_Err = "Word is required";
        $_SESSION['word'] = $_POST['word'];
    } else {
        $count += 1;
        $_SESSION['word'] = $_POST['word'];
    }
    if (empty($_POST["vietnamese_meaning"])) {
        $vietnamese_meaning_Err = "Vietnamese meaning is required";
        $_SESSION['vietnamese_meaning'] = $_POST['vietnamese_meaning'];
    } else {
        $count += 1;
        $_SESSION['vietnamese_meaning'] = $_POST['vietnamese_meaning'];
    }
    if (empty($_POST["similar_words"])) {
        $similar_words_Err = "Similar words are required";
        $_SESSION['similar_words'] = $_POST['similar_words'];
    } else {
        $count += 1;
        $_SESSION['similar_words'] = $_POST['similar_words'];
    }
    if (empty($_POST["example_one"])) {
        $example_one_Err = "Example 1 is required";
        $_SESSION['example_one'] = $_POST['example_one'];
    } else {
        $count += 1;
        $_SESSION['example_one'] = $_POST['example_one'];
    }
    if (empty($_POST["example_two"])) {
        $example_two_Err = "Example 2 is required";
        $_SESSION['example_two'] = $_POST['example_two'];
    } else {
        $count += 1;
        $_SESSION['example_two'] = $_POST['example_two'];
    }
    if ($count == 5) {
        header("Location: actions/update_a_word_action.php");
    }
}
if($_GET['id'] != null) {
    $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM words WHERE id='".$_GET['id']."'";
    $data = mysqli_query($conn, $sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
        $_SESSION['id_update_word'] = $_GET['id'];
        $_SESSION["word"] = $_POST["word"] =  $row["word"];
        $_SESSION["vietnamese_meaning"] = $_POST["vietnamese_meaning"] = $row["vietnamese_meaning"];
        $_SESSION["similar_words"] = $_POST["similar_words"] = $row["similar_words"];
        $_SESSION["example_one"] = $_POST["example_one"] = $row["example_one"];
        $_SESSION["example_two"] = $_POST["example_two"] = $row["example_two"];
    }
    mysqli_close($conn);
} else {
    $_POST["word"] = $_SESSION["word"];
    $_POST["vietnamese_meaning"] = $_SESSION["vietnamese_meaning"];
    $_POST["similar_words"] = $_SESSION["similar_words"];
    $_POST["example_one"] = $_SESSION["example_one"];
    $_POST["example_two"] = $_SESSION["example_two"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update a Word</title>
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
            <input placeholder="Word" class="form-control" type="text" name="word" value="<?php echo isset($_POST['word']) ? $_POST['word'] : '' ?>">
            <span class="error">* <?php echo $word_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Vietnamese meaning" class="form-control" type="text" name="vietnamese_meaning" value="<?php echo isset($_POST['vietnamese_meaning']) ? $_POST['vietnamese_meaning'] : '' ?>">
            <span class="error">* <?php echo $vietnamese_meaning_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Similar words" class="form-control" type="text" name="similar_words" value="<?php echo isset($_POST['similar_words']) ? $_POST['similar_words'] : '' ?>">
            <span class="error">* <?php echo $similar_words_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Example 1" class="form-control" type="text" name="example_one" value="<?php echo isset($_POST['example_one']) ? $_POST['example_one'] : '' ?>">
            <span class="error">* <?php echo $example_one_Err;?></span>
        </div>
        <div class="form-group">
            <input placeholder="Example 2" class="form-control" type="text" name="example_two" value="<?php echo isset($_POST['example_two']) ? $_POST['example_two'] : '' ?>">
            <span class="error">* <?php echo $example_two_Err;?></span>
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