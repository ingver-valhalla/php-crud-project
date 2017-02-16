<div class="content-block">
<?php if (session_status() !== PHP_SESSION_ACTIVE): ?>
  <p class="message warning">Вы должны быть авторизованы, чтобы иметь возможность изменять данные</p>
<?php endif; ?>
  <noscript>
    <p class="message error">Для изменения данных необходим <strong>Javascript</strong></p>
  </noscript>
<?php if ($result): ?>
  <?php if ($result->num_rows): ?>

    <table class="content">
      <?php $fields = $result->fetch_fields(); ?>

      <tr>
        <?php foreach($fields as $field): ?>

        <th><?php echo($field->name) ?>

        <?php endforeach; ?>
      </tr>

      <?php while($row = $result->fetch_assoc()): ?>

      <tr>
        <?php foreach($row as $field => $value): ?>

        <td><?php echo($row[$field]) ?></td>

        <?php endforeach; ?>
      </tr>

      <?php endwhile; ?>

    </table>

  <?php else: ?>

    <p><em>Пусто</em></p>

  <?php endif; ?>
<?php else: ?>

  <p><strong>Ошибка в запросе</strong></p>

<?php endif; ?>
</div>
