<div class="user-block">
  <?php if (session_status() == PHP_SESSION_ACTIVE): ?>

  <div class="user-status">
    <span class="login"><strong><?php echo $_SESSION['login'] ?></strong></span>
    <span class="separator">|</span>
    <a href="logout.php">Выйти</a>
  </div>

  <?php else: ?>

  <div class="user-status">
    <a href="login.php">Войти</a>
    <span class="separator">|</span>
    <a href="register.php">Зарегистрироваться</a>
  </div>

  <?php endif; ?>
</div>
