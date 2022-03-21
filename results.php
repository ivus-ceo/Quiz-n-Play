<?php
  require 'php/db.php';
  session_start();
  date_default_timezone_set('Asia/Omsk');

  if (isset($_POST['submit-test']) || isset($_POST)) {
    $subject_name = $_POST['subject-name'];
    $user_name = $_POST['user-name'];
    $user_email = $_POST['user-email'];
    $user_id = $_POST['user-id'];
    $result_start_date = $_POST['result-start-date'];
    $result_subject_name = $_POST['subject-name'];
    $result_date = date('d.m.Y H:i');
    $test_uniqid = $_POST['test-uniqid'];
    $array_questions = $_POST['question'];
    $array_answers = $_POST['answer'];

    $count = count($array_questions);

    $sql = "SELECT * FROM tests WHERE test_uniqid = '$test_uniqid' AND test_right_answer = 1";
    $result = mysqli_query($link, $sql);
    $right_answers = 0;
    $index = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['test_answer'] == $array_answers[$index]) {
        $right_answers++;
      }
      $index++;
    }

    $sql = "INSERT INTO results (result_uid, result_username, result_user_email, result_subject_name, results_questions, result_rights_answers, result_start_date, result_date) VALUES ('$user_id', '$user_name', '$user_email', '$result_subject_name', '$count', '$right_answers', '$result_start_date', '$result_date')";
    $result = mysqli_query($link, $sql);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'includes/head.php'; ?>
    <title>WTT | Результаты тестирования</title>
  </head>
  <body>
    <?php include 'includes/nav.php'; ?>

    <section>
      <div class="result-container">
        <div class="progress">
          <div class="result-message">
            <?php
              if ($right_answers == $count) {
                echo "<h1>Поздравляю, вы отлично справились!</h1>";
              } elseif ($right_answers < $count && $right_answers > 0) {
                echo "<h1>Неплохой результат!</h1>";
              } else {
                echo "<h1>Попробуйте еще раз, будет лучше</h1>";
              }
            ?>
          </div>

          <div class="progress-title">
            <p><?php echo $subject_name; ?></p>
            <p><?php echo "Правильных ответов: ".$right_answers."/".$count; echo ' ('.round((($right_answers / $count) * 100)).'%)' ?></p>
          </div>

          <div class="progress-bar">
            <div class="bar" style="<?php echo 'width:'.round((($right_answers / $count) * 100)).'%' ?>"></div>
          </div>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/main.js"></script>
  </body>
</html>
