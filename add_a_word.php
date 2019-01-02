<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
}

$word_Err = $vietnamese_meaning_Err = $similar_words_Err = $example_one_Err = $example_two_Err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $count = 0;
        if (empty($_POST["word"])) {
            $word_Err = "Word is required";
        } else {
            $count += 1;
        }
        if (empty($_POST["vietnamese_meaning"])) {
            $vietnamese_meaning_Err = "Vietnamese meaning is required";
        } else {
            $count += 1;
        }
        if (empty($_POST["similar_words"])) {
            $similar_words_Err = "Similar words are required";
        } else {
            $count += 1;
        }
        if (empty($_POST["example_one"])) {
            $example_one_Err = "Example 1 is required";
        } else {
            $count += 1;
        }
        if (empty($_POST["example_two"])) {
            $example_two_Err = "Example 2 is required";
        } else {
            $count += 1;
        }
        if ($count == 5) {
            $_SESSION['word'] = $_POST['word'];
            $_SESSION['vietnamese_meaning'] = $_POST['vietnamese_meaning'];
            $_SESSION['similar_words'] = $_POST['similar_words'];
            $_SESSION['example_one'] = $_POST['example_one'];
            $_SESSION['example_two'] = $_POST['example_two'];
            header("Location: actions/add_a_word_action.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add a Word</title>
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
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>