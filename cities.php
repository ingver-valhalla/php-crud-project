<?php
  include 'auth_check.php';

  include 'db_connect.php';
  $query = 'SELECT * from cities';
  include 'db_query_close.php';

  $section = 'Города';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_content.php';
  $menu_items = include 'menu_items.php';
  $menu_items['cities']->active = TRUE;

  include 'tpl_main.php';
