<?php
  $db = mysqli_connect('127.0.0.1', 'ingver', '60631_shhia', '60631_shhia');
  if (!$db) {
    echo 'Ошибка: Не удалось установить соединение с базой данных <br>';
    echo 'Код ошибки errno: ' . mysqli_connect_errno() . '<br>';
    echo 'Текст ошибки error: ' . mysqli_connect_error() . '<br>';
    exit;
  }
?>
