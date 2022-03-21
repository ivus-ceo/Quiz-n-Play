<?php
  require 'php/db.php';
  session_start();
  date_default_timezone_set('Asia/Omsk');

  if (!empty($_GET['subject_uniqid'])) {
    $test_uniqid = $_GET['subject_uniqid'];
    $sql = "SELECT * FROM tests WHERE test_uniqid = '$test_uniqid' AND test_right_answer = 1 ORDER BY test_id";
    $data = mysqli_query($link, $sql);
  }

  if (!isset($_SESSION['id'])) {
    header('Location: ./');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'includes/head.php'; ?>
    <title>Quiz & Play | <?php echo $_SESSION['name']." ".$_SESSION['last']; ?></title>
  </head>
  <body onload="__setTimer()">
    <?php include 'includes/nav.php'; ?>

    <section>
      <div class="quiz-container" id="Quiz">
        <div class="quiz-title">
          <h2>
            <?php
              $sql = "SELECT * FROM subjects WHERE subject_uniqid = '$test_uniqid'";
              $result = mysqli_query($link, $sql);
              $subject_name = mysqli_fetch_assoc($result);
              echo $subject_name['subject_name'];
            ?>
          </h2>
        </div>

        <div class="quiz-questions-container" timer="<?php echo $subject_name['subject_test_time'] ?>">
          <form action="results.php" method="POST" id="testForm">
            <input type="hidden" name="user-name" value="<?php echo $_SESSION['name']." ".$_SESSION['last'] ?>">
            <input type="hidden" name="user-email" value="<?php echo $_SESSION['email']; ?>">
            <input type="hidden" name="user-id" value="<?php echo $_SESSION['id']; ?>">
            <input type="hidden" name="test-uniqid" value="<?php echo $test_uniqid ?>">
            <input type="hidden" name="result-start-date" value="<?php echo date('d.m.Y H:i') ?>">
            <input type="hidden" name="subject-name" value="<?php echo $subject_name['subject_name'] ?>">
            <?php
              $i = 1;
              while ($row = mysqli_fetch_assoc($data)):
                $question_uniqid = $row['test_question_uniqid'];
                $sql = "SELECT * FROM tests WHERE test_question_uniqid = '$question_uniqid' ORDER BY RAND()";
                $result = mysqli_query($link, $sql);
            ?>

            <div class="left-column">
              <h3><?php echo $i.". ".$row['test_question'] ?></h3>
            </div>

            <div class="right-column">
              <h4>Ответы на вопросы:</h4>

              <div class="multiple">
                <?php
                  while ($answer = mysqli_fetch_assoc($result)):
                ?>

                <div class="answer">
                  <div class="input-container">
                    <input type="hidden" name="question[<?php echo $i ?>]" value="<?php echo $row['test_question']; ?>">
                    <input type="radio" name="answer[<?php echo $i ?>]" value="<?php echo $answer['test_answer'] ?>">
                    <div class="checkmark"></div>
                  </div>
                  <div class="answer-title"><?php echo $answer['test_answer'] ?></div>
                </div>

                <?php
                  endwhile;
                ?>
              </div>
            </div>

            <?php
                $i++;
              endwhile;
            ?>

            <div class="bottom-column">
              <div class="bottom-headline">
                <h4 id="timer">Осталось:</h4>
                <button type="submit" name="submit-test">Завершить тест</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <?php if (empty($_GET['subject_uniqid'])): ?>
      <script>
        alert('Вы не выбрали тест для прохождения!');
        window.location.replace("./?error=uniqid-is-not-defined");
      </script>
    <?php endif; ?>

    <script src="js/main.js"></script>
  </body>
</html>
