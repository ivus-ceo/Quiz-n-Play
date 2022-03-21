<?php
  require 'php/db.php';
  session_start();
  date_default_timezone_set('Asia/Omsk');

  if (!isset($_SESSION['id']) && $_SESSION['status'] !== 1) {
    header('Location: ./');
  }

  if (isset($_POST['subject-button'])) {
    /* <== Данные с формы ==> */
    $subject_name = $_POST['subject-name'];
    $subject_description = $_POST['subject-description'];
    $subject_creator = $_POST['subject-creator'];
    $subject_uniqid = $_POST['subject-uniqid'];
    $subject_date = date('d.m.Y');
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

    $sql = "INSERT INTO subjects (subject_name, subject_description, subject_amount, subject_creator, subject_uniqid, subject_date) VALUES ('$subject_name', '$subject_description', '$question_amount', '$subject_creator', '$subject_uniqid', '$subject_date')";
    mysqli_query($link, $sql);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'includes/head.php'; ?>
    <title>WTT | Панель администратора</title>
  </head>
  <body>
    <div class="content-wrapper">
      <!--php/wtt-new-quiz.php-->
      <form action="make.php" method="POST">
        <input type="hidden" name="subject-creator" value="<?php echo $_SESSION['name']." ".$_SESSION['last']; ?>">
        <input type="hidden" name="subject-uniqid" value="<?php echo uniqid(); ?>">

        <div class="name-of-subject">
          <input type="text" name="subject-name" placeholder="Имя дисциплины" required>
          <textarea name="subject-description" placeholder="Описание дисциплины" required></textarea>
        </div>

        <div class="question-container">
          <div class="question">
            <div class="question-title">
              <textarea name="questions[]" placeholder="Вопрос" required></textarea>
              <div onclick="remove_question(this)"><i class="fas fa-times"></i></div>
            </div>

            <div class="question-answer">
              <input type="text" name="answers[][true-answer]" placeholder="Правильный вариант..." required>
              <div><i class="fas fa-check"></i></div>
            </div>

            <div class="question-answer">
              <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." required>
              <div><i class="fas fa-times"></i></div>
            </div>

            <div class="question-answer">
              <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." required>
              <div><i class="fas fa-times"></i></div>
            </div>

            <div class="add-question-answer" onclick="add_answer(this)">
              <input type="text" placeholder="Добавить вариант..." readonly>
              <div><i class="fas fa-plus"></i></div>
            </div>
          </div>
        </div>

        <div class="add-question" onclick="add_question(this)">
          <p>Добавить новый вопрос<i class="fas fa-plus"></i></p>
        </div>

        <div class="submit-button">
          <button type="submit" name="subject-button">Create</button>
        </div>
      </form>
    </div>

    <script>
      function add_question(e) {
        var a = $('.question-container .question:nth-of-type(1)').html();
        $('.question-container .question:nth-last-of-type(1)').after('<div class="question">' + a + '</div>');
      }

      function remove_question(e) {
        $(e).parentsUntil('.question-container').remove();
      }

      function add_answer(e) {
        var a = $('.question-container .question .question-answer:nth-child(4)').html();
        console.log(a);
        $('.question-container .question .add-question-answer').before('<div class="question-answer">' + a + '</div>');
      }

      function myFunction(e) {
        var a = $(e).attr('name').substr(15, 18);
        console.log(a);
      }
    </script>

  </body>
</html>
