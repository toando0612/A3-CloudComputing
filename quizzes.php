<?php
session_start();

if (!$_SESSION['is_logged_in']) {
    header("Location: login.php");
} else {
    if ($_SESSION['is_admin_logged_in']) {
        header("Location: index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Words</title>
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
<?php
$conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    if (empty($_SESSION['seqid'])){
        $idword = "8";
    }else {
        $list = array();
        $list = $_SESSION['seqid'];
        $idword = end($list);
    }
$sql = "SELECT * FROM words having id IN ($idword) limit 1";
$data = mysqli_query($conn, $sql);
if (mysqli_num_rows($data) > 0) {
    $row = mysqli_fetch_assoc($data);
    $word = $row["word"];
    $correct = $row["vietnamese_meaning"];
    $array = array();
    array_push($array, $correct);
    $_SESSION["correct"] = $correct;
    $array_id = array();
    array_push($array_id, $idword);
    for ($i = 1; $i <=3; $i++){
        $id_except = implode(",", $array_id);
        $sql = "SELECT * FROM words having id NOT IN ($id_except) ORDER BY RAND() LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $means = mysqli_fetch_assoc($result);
        $mean = $means["vietnamese_meaning"];
        $newid = $means["id"];
        array_push($array_id, $newid);
        array_push($array, $mean);
    }
    shuffle($array);

    echo "<div class='container'>";
        if(isset($_SESSION['message']['text'])) {
            // Display message
            echo "<div class=\"alert alert-{$_SESSION['message']['type']}\">{$_SESSION['message']['text']}</div>";
            // Display message from session
            unset($_SESSION['message']['text']);
        }
    echo "<h3>What is the meaning of $word?</h3>";
    ?>
    <form action="actions/do_quizzes.php" method="POST">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline1" name="answer" value="<?php echo $array[0]; ?>" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline1"><?php echo $array[0]; ?></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="answer" value="<?php echo $array[1]; ?>" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2"><?php echo $array[1]; ?></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline3" name="answer" value="<?php echo $array[2]; ?>" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline3"><?php echo $array[2]; ?></label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline4" name="answer" value="<?php echo $array[3]; ?>" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline4"><?php echo $array[3]; ?></label>
        </div>
        <button type="submit" class="btn btn-outline-primary" name="submit">Submit your answer</button>
    </form>
    <?php
}
mysqli_close($conn);
?>

<br>
<footer class="page-footer font-small lighten-5"">
<div class="footer-copyright text-center text-black-50 py-3">
    <p>Copyright &copy; <?php echo date('Y') ?> Tuan Le</p>
</div>
</body>
</html>