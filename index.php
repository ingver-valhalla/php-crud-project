<?php
  include 'auth_check.php';

  if (session_status() == PHP_SESSION_ACTIVE) {
    if (!key_exists('times', $_SESSION)) {
      $_SESSION['times'] = 0;
    } else {
      $_SESSION['times']++;
    }
  }

  $section = 'Главная страница';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_index_content.php';

  include 'tpl_main.php';
