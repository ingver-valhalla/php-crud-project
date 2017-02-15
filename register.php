<?php
  include 'auth_check.php';

  if (session_status() == PHP_SESSION_ACTIVE) {
      header('Location: ./index.php');
      exit;

  } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!key_exists('login', $_POST) || $_POST['login'] == '' ||
        !key_exists('password', $_POST) || $_POST['password'] == '' ||
        !key_exists('repeat', $_POST) || $_POST['repeat'] == '') {

      $message = 'Необходимо заполнить поля формы!';
      $message_class = 'warning';

    } else if ($_POST['password'] !== $_POST['repeat']) {
      $message = 'Пароли должны совпадать!';
      $message_class = 'warning';

    } else {
      include 'db_connect.php';

      $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
      //$hash = $_POST['password'];
      $query = "INSERT INTO users (login, password) VALUES ('" . $_POST['login'] . "', '$hash')";

      if ($db->query($query)) {
        $db->close();

        session_start();
        $_SESSION['login'] = $_POST['login'];
        //echo $hash;
        header('Location: ./index.php');
        exit;

      } else {
        if ($db->errno == 1062) { // Duplicate entry '%s' for key %d
          $message = 'Пользователь с таким именем уже сущeствует';
          $message_class = 'error';

        } else {
          $message = 'Возникла ошибка при регистрации. Попробуйте снова<br>';
          $message = $message . 'Код ошибки: ' . $db->errno;
          $message_class = 'error';
          //echo '<p>' . $db->error . '</p>';
          //print_r($_POST);
          //print_r($hash);
        }
        $db->close();
      }
    }
  }

  $section = 'Регистрация';
  $user_block = 'tpl_user_block.php';
  $menu = 'tpl_menu.php';
  $content = 'tpl_register.php';

  $menu_items = include 'menu_items.php';

  include 'tpl_main.php';
?>
