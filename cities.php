<?php
  include 'auth_check.php';

  include 'db/connect.php';
  $query = 'SELECT * from cities';
  $result = $db->query($query);
  $db->close();

  $section = 'Города';
  $user_block = 'templates/user_block.php';
  $menu = 'templates/menu.php';
  $content = 'templates/content.php';
  $menu_items = include 'menu_items.php';
  $menu_items['cities']->active = TRUE;
  $scripts = array('client/content.js', 'client/menu.js');

  include 'templates/main.php';
