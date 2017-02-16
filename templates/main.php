<!DOCTYPE html5>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $section ?> | Предприятие</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Rubik" rel="stylesheet">
  </head>
  <body>

    <?php
      include $user_block;
      include $menu;
      include $content;
    ?>

    <script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/vue.resource/1.2.0/vue-resource.js"></script>
    <?php include 'client/tpl_content.html' ?>
    <?php include 'client/tpl_menu.html' ?>

    <?php foreach($scripts as $script): ?>
      <script src="<?php echo $script ?>"></script>
    <?php endforeach; ?>
  </body>
</html>
