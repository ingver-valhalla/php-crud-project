<?php
  include 'auth_check.php';

  $query = 'SELECT * from providers';
  $result = include 'db_get.php';

  $section = 'Поставщики';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_content.php';

  include 'tpl_main.php';
?>
