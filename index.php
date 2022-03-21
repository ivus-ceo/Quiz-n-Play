<?php
  require 'php/db.php';
  session_start();
  date_default_timezone_set('Asia/Omsk');
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include 'includes/head.php'; ?>
    <title>Quiz & Play | Добро пожаловать!</title>
  </head>
  <body>
    <?php include 'includes/nav.php'; ?>

    <main data-aos="fade-up">
      <div class="main-container">
        <div class="main-information">
          <h1>Quiz & Play</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <div class="information-buttons">
            <?php if (!isset($_SESSION['id'])) { ?>
              <p>Для того, чтобы протестироваться, нужно для начала <a href="#Signup">зарегистрироваться</a>, это не займет много времени!</p>
            <?php } else { ?>
              <p>Теперь, чтобы протестироваться, нужно выбрать тест в разделе <a href="#Subjects">предметы</a>, да прибудет с вами сила</p>
            <?php } ?>

          </div>
        </div>
      </div>
    </main>

    <section data-aos="fade-up">
      <div class="section-container" id="Steps">
        <div class="section-title">
          <h1>Шаги для начала использования:</h1>
        </div>

        <div class="startup-section">
          <div class="step-container">
            <div class="step-count">
              <h1>01</h1>
            </div>

            <div class="step-description">
              <h2>Зарегистрируйтесь!</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>

          <div class="step-container">
            <div class="step-count">
              <h1>02</h1>
            </div>

            <div class="step-description">
              <h2>Можете создать свой тест</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>

          <div class="step-container">
            <div class="step-count">
              <h1>03</h1>
            </div>

            <div class="step-description">
              <h2>Люди тестируются</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>

          <div class="step-container">
            <div class="step-count">
              <h1>04</h1>
            </div>

            <div class="step-description">
              <h2>Получаете результаты</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section data-aos="fade-up">
      <div class="section-container" id="Subjects">
        <div class="section-title">
          <h1>Последние тесты по предметам:</h1>
        </div>

        <div class="subject-section">
          <?php
            $sql = "SELECT * FROM subjects ORDER BY subject_id LIMIT 9";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)):
          ?>

          <div class="subject-container">
            <div class="subject-title">
              <h2><a href="test?subject_uniqid=<?php echo $row['subject_uniqid'] ?>"><?php echo $row['subject_name'] ?></a></h2>
              <div class="subject-author">
                <p>Автор: <a href="profile?id=<?php echo $row['subject_uid'] ?>"><?php echo $row['subject_creator'] ?></a></p>
                <p>Вопросов: <?php echo $row['subject_amount'] ?></p>
              </div>
            </div>

            <div class="subject-description">
              <p><?php echo $row['subject_description'] ?></p>
              <div class="subject-information">
                <p><?php echo $row['subject_date'] ?></p>
                <a href="test?subject_uniqid=<?php echo $row['subject_uniqid'] ?>">Протестироваться<i class="fad fa-arrow-to-right"></i></a>
              </div>
            </div>
          </div>

          <?php endwhile; ?>
        </div>
      </div>
    </section>

    <?php if (!isset($_SESSION['id'])): ?>
    <section data-aos="fade-up">
      <div class="section-container" id="Signup">
        <div class="section-title">
          <h1>Войти для тестирования</h1>
        </div>

        <div class="signup-section">
          <div class="signup-container">
            <h2>Зарегистрироваться</h2>
            <form action="php/wtt-new-user.php" method="POST">
              <input type="text" name="name" placeholder="Имя" required>
              <input type="text" name="last" placeholder="Фамилия" required>
              <input type="text" name="email" placeholder="E-Mail" required>
              <input type="text" name="login" placeholder="Логин" required>
              <input type="password" name="password" minlength="6" placeholder="Пароль" required>
              <button type="submit" name="signup-button">Завершить регистрацию</button>
            </form>
          </div>

          <div class="login-container">
            <h2>Авторизироваться</h2>
            <form action="php/wtt-login-user.php" method="POST">
              <input type="text" name="login-email" placeholder="Логин / E-Mail">
              <input type="password" name="password" minlength="6" placeholder="Пароль">
              <button type="submit" name="login-button">Войти в систему</button>
            </form>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>

    <script src="js/main.js"></script>
  </body>
</html>
