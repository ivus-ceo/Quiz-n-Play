<nav>
  <div class="navbar-container">
    <div class="navbar">
      <div class="upper-navbar">
        <div class="left-column">
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>

        <div class="right-column">
          <a href="#"><i class="fas fa-envelope"></i>Связаться</a>
          <a href="#"><i class="fas fa-briefcase"></i>Вакансии</a>
          <a href="#"><i class="fas fa-info-circle"></i>О нас</a>
        </div>
      </div>
    </div>
  </div>

  <div class="navbar-container">
    <div class="navbar">
      <div class="lower-navbar">
        <div class="nav-logo">
          <a href="./">Quiz & Play</a>
        </div>

        <div class="nav-links">
          <a href="./"><i class="fas fa-home"></i>Главная</a>
          <a href="./#Steps"><i class="fas fa-play"></i>Начало</a>
          <a href="./#Subjects"><i class="fas fa-book"></i>Предметы</a>
          <a href="test"><i class="fas fa-spell-check"></i>Тестирование</a>
          <?php if (isset($_SESSION['id'])) { ?>
            <a href="profile"><i class="fas fa-address-book"></i>Профиль</a>
            <a href="logout?logout=true"><i class="fas fa-sign-out-alt"></i>Выйти</a>
          <?php } elseif (isset($_SESSION['id']) && $_SESSION['status'] == 1) { ?>
            <a href="#Profile"><i class="fas fa-address-book"></i>Админ</a>
          <?php } else { ?>
            <a href="#Signup"><i class="fas fa-sign-in-alt"></i>Войти</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</nav>
