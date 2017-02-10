<?php include('db_connect.php') ?>

<?php $result = $db->query($query); ?>

<?php if ($result): ?>
  <?php //var_dump($result); ?>
  <?php if ($result->num_rows): ?>

    <table border="1">
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

<?php include('db_close.php') ?>
