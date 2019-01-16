<?php
session_start();
    $correct = $_SESSION['correct'];
    $answer = $_POST['answer'];
    if ($_SESSION["checkmode"] == "seq"){
        if ($answer == $correct) {
            $_SESSION['message'] = array(
                'text' => 'Correct!',
                'type' => 'success');
            header("Location: ../learn_a_word_seq.php");
        }else{
            $_SESSION['message'] = array(
                'text' => 'Incorrect, try again!',
                'type' => 'danger');
            header("Location: ../quizzes.php");
        }
    }elseif ($_SESSION["checkmode"] == "ran"){
        if ($answer == $correct) {
            $_SESSION['message'] = array(
                'text' => 'Correct!',
                'type' => 'success');
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