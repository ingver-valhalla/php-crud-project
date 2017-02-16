<?php
  include 'auth_check.php';

  $section = 'Главная страница';
  $user_block = 'templates/user_block.php';
  $menu = 'templates/menu.php';
  $content = 'templates/index_content.php';
  $menu_items = include 'menu_items.php';
  $menu_items['index']->active = TRUE;
  $scripts = array('client/content.js', 'client/menu.js');

  include 'templates/main.php';
