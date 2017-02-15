<?php
  include 'auth_check.php';

  if (session_status() == PHP_SESSION_ACTIVE) {
      header('Location: ./index.php');
      exit;
  } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!key_exists('login', $_POST) || $_POST['login'] == '' ||
        !key_exists('password', $_POST) || $_POST['password'] == '') {

        echo '<p>Необходимо заполнить поля формы!</p>';

    } else {
      include 'db_connect.php';

      $query = "SELECT * from users WHERE login = '" . $_POST['login'] . "'";
      $result = $db->query($query);

      if (!$result) {
        $db->close();
        echo '<p>Непредвиденная ошибка. Код:' . $db->errno . '</p>';

      } else if (!$result->num_rows) {
        echo '<p>Не найден пользователь с таким именем</p>';

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
          echo '<p>Не найдено соответствующей пары логин/пароль</p>';
          //$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
          //echo '<p>' . $hash . '</p>';
        }
      }
    }
  }
?>

<form action="login.php" method="post">
  <p>Логин: <input type="text" name="login"></p>
  <p>Пароль: <input type="password" name="password"></p>
  <p><input type="submit" value="Войти"></p>
</form>
