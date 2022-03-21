<?php
  require 'php/db.php';
  session_start();
  date_default_timezone_set('Asia/Omsk');

  if (!isset($_SESSION['id'])) {
    header('Location: ./');
  }

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = $_SESSION['id'];
  }

  $sql = "SELECT * FROM users WHERE user_id = '$id'";
  $result = mysqli_query($link, $sql);
  $user_output = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'includes/head.php'; ?>
    <title>Quiz & Play | <?php echo $_SESSION['name']." ".$_SESSION['last']; ?></title>
  </head>
  <body>
    <?php include 'includes/nav.php'; ?>

    <section>
      <div class="profile-section">
        <div class="profile">
          <div class="profile-username">
            <img src="media/images/user.png" alt="Avatar">
            <p><?php echo $user_output['user_name']." ".$user_output['user_last']; ?></p>
          </div>
          <div class="profile-results">
            <?php if ($user_output['user_id'] == $_SESSION['id']): ?>
              <h1>Ваши последние результаты:</h1>
            <?php endif; ?>

            <?php if ($user_output['user_id'] != $_SESSION['id']): ?>
              <h1>Последние результаты пользователя:</h1>
            <?php endif; ?>

            <?php
              $sql = "SELECT * FROM results WHERE result_uid = '$id' ORDER BY result_id LIMIT 20";
              $result = mysqli_query($link, $sql);
              if (mysqli_num_rows($result) < 1) {
                echo "Результаты по тестированию отсутствуют";
              } else {
                while($row = mysqli_fetch_assoc($result)):
            ?>

            <div class="result">
              <h1><?php echo $row['result_subject_name'] ?></h1>
              <div class="result-progress-bar-container">
                <div class="result">
                  <p><?php echo $row['result_rights_answers']."/".$row['results_questions'] ?></p>
                  <p><?php echo $row['result_date'] ?></p>
                </div>
                <div class="progress-bar">
                  <div class="bar" style="<?php echo "width:".round((($row['result_rights_answers'] / $row['results_questions']) * 100))."%" ?>"></div>
                </div>
              </div>
            </div>

            <?php endwhile; } ?>
          </div>

          <?php if ($user_output['user_id'] == $_SESSION['id'] && $_SESSION['status'] == 1): ?>
            <div class="profile-create" data-aos="fade-up">
              <menu>
                <h1>Создание теста</h1>
                <a href="#" onclick="__summonOneRow(this)"><i class="fas fa-square"></i>Одна строка</a>
                <a href="#" onclick="__summonTwoRow(this)"><i class="fas fa-th-large"></i>Две строки</a>
                <a href="#" onclick="__summonThreeRow(this)"><i class="fas fa-th"></i>Три строки</a>
              </menu>

              <div class="content-wrapper">
                <form action="php/wtt-new-quiz.php" method="POST">
                  <input type="hidden" name="subject-creator" value="<?php echo $_SESSION['name']." ".$_SESSION['last']; ?>">
                  <input type="hidden" name="subject-uniqid" value="<?php echo uniqid(); ?>">

                  <div class="name-of-subject">
                    <input type="text" name="subject-name" placeholder="Имя дисциплины" autocomplete="off" required>
                    <input type="number" name="subject-time" placeholder="Время теста в минутах" autocomplete="off" required>
                    <textarea name="subject-description" placeholder="Описание дисциплины" maxlength="150" autocomplete="off" required></textarea>
                  </div>

                  <div class="question-container">
                    <div class="question">
                      <div class="question-title">
                        <textarea name="questions[]" placeholder="Вопрос" autocomplete="off" required></textarea>
                        <div onclick="__removeQuestion(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][true-answer]" placeholder="Правильный вариант..." autocomplete="off" required>
                        <div onclick="__rightAnswer(this)"><i class="fas fa-check"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="add-question-answer" onclick="__addAnswer(this)">
                        <input type="text" placeholder="Добавить вариант..." autocomplete="off" readonly>
                        <div><i class="fas fa-plus"></i></div>
                      </div>
                    </div>

                    <div class="question">
                      <div class="question-title">
                        <textarea name="questions[]" placeholder="Вопрос" autocomplete="off" required></textarea>
                        <div onclick="__removeQuestion(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][true-answer]" placeholder="Правильный вариант..." autocomplete="off" required>
                        <div onclick="__rightAnswer(this)"><i class="fas fa-check"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="add-question-answer" onclick="__addAnswer(this)">
                        <input type="text" placeholder="Добавить вариант..." autocomplete="off" readonly>
                        <div><i class="fas fa-plus"></i></div>
                      </div>
                    </div>

                    <div class="question">
                      <div class="question-title">
                        <textarea name="questions[]" placeholder="Вопрос" autocomplete="off" required></textarea>
                        <div onclick="__removeQuestion(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][true-answer]" placeholder="Правильный вариант..." autocomplete="off" required>
                        <div onclick="__rightAnswer(this)"><i class="fas fa-check"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="question-answer">
                        <input type="text" name="answers[][false-answer]" placeholder="Дополнительный вариант..." autocomplete="off" required>
                        <div onclick="__removeAnswer(this)"><i class="fas fa-times"></i></div>
                      </div>

                      <div class="add-question-answer" onclick="__addAnswer(this)">
                        <input type="text" placeholder="Добавить вариант..." autocomplete="off" readonly>
                        <div><i class="fas fa-plus"></i></div>
                      </div>
                    </div>
                  </div>

                  <div class="add-question" onclick="__addQuestion(this)">
                    <p>Добавить новый вопрос<i class="fas fa-plus"></i></p>
                  </div>

                  <div class="submit-button">
                    <button type="submit" name="subject-button">Создать тест</button>
                  </div>
                </form>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/main.js"></script>
  </body>
</html>
