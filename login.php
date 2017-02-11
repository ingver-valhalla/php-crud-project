<?php
  include 'auth_check.php';
  if (session_status() == PHP_SESSION_ACTIVE) {
      header('Location: ./index.php');
      exit;
  } else {
    if (key_exists('login', $_POST) && key_exists('password', $_POST)) {
      if ($_POST['login'] == 'ingver' && $_POST['password'] == '1234') {
        session_start();
        $_SESSION['login'] = 'ingver';
        header('Location: ./index.php');
        exit;
      }
    }
  }
?>
<form action="login.php" method="post">
  <p>Логин: <input type="text" name="login"></p>
  <p>Пароль: <input type="text" name="password"></p>
  <p><input type="submit" value="Войти"></p>
</form>
