<div class="content-block">
  <p class="message info">Выберете секцию в меню</p>
  <?php if (session_status() !== PHP_SESSION_ACTIVE): ?>
    <p class="message warning">Вы должны быть авторизованы, чтобы иметь возможность изменять данные</p>
  <?php endif; ?>
  <noscript>
    <p class="message error">Для изменения данных необходим <strong>Javascript</strong></p>
  </noscript>
</div>
