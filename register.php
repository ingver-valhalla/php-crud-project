<?php
  include 'auth_check.php';

  if (session_status() == PHP_SESSION_ACTIVE) {
      header('Location: ./index.php');
      exit;

  } else {
    if (key_exists('login', $_POST) && key_exists('password', $_POST)) {
      include 'db_connect.php';

      $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
      //$hash = $_POST['password'];
      $query = 'INSERT INTO users (login, password) VALUES (\'' . $_POST['login'] . '\', \'' . $hash . '\')';

      if ($db->query($query)) {
        $db->close();

        session_start();
        $_SESSION['login'] = $_POST['login'];
        //echo $hash;
        header('Location: ./index.php');
        exit;

      } else {
        if ($db->errno == 1062) { // Duplicate entry '%s' for key %d
          echo '<p>Пользователь с таким именем уже сущeствует</p>';
        } else {
          echo '<p>Возникла ошибка при регистрации. Попробуйте снова</p>';
          echo '<p>Код ошибки: ' . $db->errno . '</p>';
          //echo '<p>' . $db->error . '</p>';
          //print_r($_POST);
          //print_r($hash);
        }
        $db->close();
      }
    }
  }
?>

<form action="register.php" method="post">
  <p>Логин: <input type="text" name="login"></p>
  <p>Пароль: <input type="text" name="password"></p>
  <p><input type="submit" value="Отправить"></p>
</form>
