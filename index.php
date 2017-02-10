<?php include('auth.php') ?>
<?php
  if (session_status() == PHP_SESSION_ACTIVE) {
    if (!key_exists('times', $_SESSION)) {
      $_SESSION['times'] = 0;
    } else {
      $_SESSION['times']++;
    }
  }
?>

<?php include('header.php') ?>

  <?php include('user_block.php') ?>

  <div class="nav-container">
    <ul class="navbar">
      <li><a href="parts.php">Детали</a></li>
      <li><a href="projects.php">Проекты</a></li>
      <li><a href="providers.php">Поставщики</a></li>
      <li><a href="cities.php">Города</a></li>
      <li><a class="start-page">Главная страница</a></li>
    </ul>
  </div>

  <div class="content">
    <p>Выберете секцию в меню</p>
    <?php if (session_status() == PHP_SESSION_ACTIVE): ?>
      <p>Вы посетили эту страницу <?php echo($_SESSION['times']); ?> раз</p>
    <?php else: ?>
      <p>Вы не авторизованы</p>
    <?php endif; ?>
  </div>

<?php include('footer.php') ?>
