<?php
  include 'auth_check.php';
  include 'db_connect.php';

  $query = 'SELECT * from providers';
  $result = include 'db_query_close.php';

  $section = 'Поставщики';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_content.php';

  include 'tpl_main.php';
