<?php
session_start();
    $correct = $_SESSION['correct'];
    $answer = $_POST['answer'];
    $word_id = $_POST['word_id'];
    $learner_id = $_SESSION["learner_id"];
if ($_SESSION["checkmode"] == "seq"){
        if ($_SESSION['skip']==true){
            $time_start = $_SESSION["time_start"];
            //connect to sql
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO records (learner_id, word_id, start, end, time_spent) VALUES ($learner_id, $word_id, '$time_start', 'Failed', 'Failed')";
            if (mysqli_query($conn, $sql)){
                $_SESSION['message'] = array(
                    'text' => 'Dont give up again !!',
                    'type' => 'danger');
                mysqli_close($conn);
                $_SESSION['is_recording_seq'] = false;
            }
            header("Location: ../learn_a_word_seq.php");
        }else{
            if ($answer == $correct) {
                $_SESSION['message'] = array(
                    'text' => 'Correct!',
                    'type' => 'success');
                $time_start = $_SESSION["time_start"];
                $time_end = microtime(true);
                $time_spent = $time_end - $time_start;  //calculate the time spend

                //connect to sql
                $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $sql = "INSERT INTO records (learner_id, word_id, start, end, time_spent) VALUES ($learner_id, $word_id, '$time_start', '$time_end', '$time_spent')";
                if (mysqli_query($conn, $sql)){
                    mysqli_close($conn);
                    $_SESSION['is_recording_seq'] = false;
                }
                header("Location: ../learn_a_word_seq.php");
            }else{
                $_SESSION['message'] = array(
                    'text' => 'Incorrect, try again!',
                    'type' => 'danger');
                header("Location: ../quizzes.php");
            }

        }

    }elseif ($_SESSION["checkmode"] == "ran"){
        if ($answer == $correct) {
            $_SESSION['message'] = array(
                'text' => 'Correct!',
                'type' => 'success');
            $time_start = $_SESSION["time_start"];
            $time_end = microtime(true);
            $time_spent = $time_end - $time_start;  //calculate the time spend

            //connect to sql
            $conn = mysqli_connect("s3618861-db.cavq78vobfpn.ap-southeast-1.rds.amazonaws.com", "imhikarucat", "12345abcde", "tuanle");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO records (learner_id, word_id, start, end, time_spent) VALUES ($learner_id, $word_id, '$time_start', '$time_end', '$time_spent')";
            if (mysqli_query($conn, $sql)){
                mysqli_close($conn);
                $_SESSION['is_recording_ran'] = false;
            }
            header("Location: ../learn_a_word_ran.php");
        }else{
            $_SESSION['message'] = array(
                'text' => 'Incorrect, try again!',
                'type' => 'danger');
            header("Location: ../quizzes.php");
        }
    }else{
        header("Location: index.php");
    }



?>