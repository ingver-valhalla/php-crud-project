<?php
  include 'auth_check.php';

  if (session_status() == PHP_SESSION_ACTIVE) {
      header('Location: ./index.php');
      exit;
  } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!key_exists('login', $_POST) || $_POST['login'] == '' ||
        !key_exists('password', $_POST) || $_POST['password'] == '') {

        $message = 'Hеобходимо заполнить поля формы!';
        $message_class = 'warning';

    } else {
      include 'db_connect.php';

      $query = "SELECT * from users WHERE login = '" . $_POST['login'] . "'";
      $result = $db->query($query);

      if (!$result) {
        $db->close();
        $message = 'Непредвиденная ошибка. Код: ' . $db->errno;
        $message_class = 'error';

      } else if (!$result->num_rows) {
        $message = 'Не найден пользователь с таким именем';
        $message_class = 'error';

      } else {
        $row = $result->fetch_assoc();
        $db->close();

        if ($_POST['login'] == $row['login'] &&
            password_verify($_POST['password'], $row['password'])) {
          session_start();
          $_SESSION['login'] = $_POST['login'];
          header('Location: ./index.php');
          exit;

        } else {
          $message = 'Не найдено соответствующей пары логин/пароль';
          $message_class = 'error';
          //$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
          //echo '<p>' . $hash . '</p>';
        }
      }
    }
  }

  $section = 'Вход';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_login.php';

  $menu_items = include 'menu_items.php';
  $scripts = array();

  include 'tpl_main.php';
?>
