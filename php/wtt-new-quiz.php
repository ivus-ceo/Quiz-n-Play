<?php
require 'db.php';
session_start();
date_default_timezone_set('Asia/Omsk');

if (isset($_POST['subject-button'])) {
  /* <== Данные с формы ==> */
  $subject_name = $_POST['subject-name'];
  $subject_description = $_POST['subject-description'];
  $subject_creator = $_POST['subject-creator'];
  $subject_uniqid = $_POST['subject-uniqid'];
  $subject_time = $_POST['subject-time'] * 60000;
  $subject_date = date('d.m.Y');
  $subject_uid = $_SESSION['id'];
  /* <== Многомерный массив в форме ==> */
  $array_questions = $_POST['questions'];
  $array_answers = $_POST['answers'];
  /* <== Находим количество всех вопросов в форме ==> */
  $question_amount = (int) count($array_questions, 0);
  /* <== Находим количество всех ответов в форме ==> */
  $answers_amount = (int) count($array_answers, 0);
  /* <== Находим разницу для цикла ==> */
  $difference = $answers_amount / $question_amount;
  /* <== Создаем переменную для счета ==> */
  $b = 0;
  /* <== Делаем цикл ==> */
  for ($i = 0; $i < $question_amount; $i++) {
    /* <== Присваиваем вопросу уникальный идентификатор ==> */
    $question_uniqid = uniqid();
    /* <== Присваиваем на основании индекса соответсвующий элемент массива ==> */
    $question = $array_questions[$i];
    /* <== Проверяем является ли ответ правильным ==> */
    for ($a = 0; $a < $difference; $a++) {
      if (!empty($array_answers[$b]['true-answer'])) {
        $answer_is_right = 1;
        $answer = $array_answers[$b]['true-answer'];
      } else {
        $answer_is_right = 0;
        $answer = $array_answers[$b]['false-answer'];
      }
      /* <== Производим итерацию счетчика ==> */
      $b++;
      /* <== Вставляем в таблицу нужные данные ==> */
      $sql = "INSERT INTO tests (test_creator, test_uniqid, test_question_uniqid, test_question, test_right_answer, test_answer, test_date) VALUES ('$subject_creator', '$subject_uniqid', '$question_uniqid', '$question', $answer_is_right, '$answer', '$subject_date')";
      mysqli_query($link, $sql);
    }
  }

  $sql = "INSERT INTO subjects (subject_name, subject_description, subject_amount, subject_test_time, subject_creator, subject_uid, subject_uniqid, subject_date) VALUES ('$subject_name', '$subject_description', '$question_amount', '$subject_time', '$subject_creator', '$subject_uid', '$subject_uniqid', '$subject_date')";
  mysqli_query($link, $sql);

  header('Location: .././?success=true');
}
?>
