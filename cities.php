<?php
  include 'auth_check.php';
  include 'db_connect.php';

  $query = 'SELECT * from cities';
  $result = include 'db_query_close.php';

  $section = 'Города';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_content.php';

  include 'tpl_main.php';
