<div class="user-status">
  <?php if (session_status() == PHP_SESSION_ACTIVE): ?>

    <span><strong><?php echo $_SESSION['login'] ?></strong><span>
    |
    <a href="logout.php">Выйти</a>

  <?php else: ?>

    <a href="login.php">Войти</a>
    |
    <a href="register.php">Зарегистрироваться</a>

  <?php endif; ?>
</div>
