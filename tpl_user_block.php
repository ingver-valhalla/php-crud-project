<div class="user-status">
  <?php if (session_status() == PHP_SESSION_ACTIVE): ?>

    <span class="login"><strong><?php echo $_SESSION['login'] ?></strong><span>
    <span class="divider">|</span>
    <a href="logout.php">Выйти</a>

  <?php else: ?>

    <a href="login.php">Войти</a>
    <span class="divider">|</span>
    |
    <a href="register.php">Зарегистрироваться</a>

  <?php endif; ?>
</div>
