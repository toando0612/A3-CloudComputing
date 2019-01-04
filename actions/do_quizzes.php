<?php
session_start();

    $correct = $_SESSION['correct'];
    $answer = $_POST['answer'];
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

?>