<div class="content">
  <p>Выберете секцию в меню</p>
  <?php if (session_status() == PHP_SESSION_ACTIVE): ?>
    <p>Вы посетили эту страницу <?php echo($_SESSION['times']); ?> раз</p>
  <?php else: ?>
    <p>Вы не авторизованы</p>
  <?php endif; ?>
</div>
