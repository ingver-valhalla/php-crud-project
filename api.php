<?php
  include 'auth_check.php';

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!isset($_SESSION)) {
      $messages[] = array(
        'type' => 'warning',
        'text' => 'Вы должны быть авторизованы, чтобы иметь возможность изменять данные');
    }

    if (isset($_GET['page']) &&
        key_exists($_GET['page'], include 'menu_items.php')) {

      if ($_GET['page'] == 'index') {

        $messages[] = array(
          'type' => 'info',
          'text' => 'Выберете секцию в меню');
        echo json_encode(
          array(
            'fields' => array(),
            'rows' => array(),
            'messages' => $messages));


      } else {

        include 'db_connect.php';

        $query = 'SELECT * from ' . $_GET['page'];
        $result = $db->query($query);

        if ($result) {
          $fields_desc = $result->fetch_fields();
          foreach($fields_desc as $desc) {
            $fields[] = $desc->name;
          }

          while($row = $result->fetch_row()) {
            $rows[] = $row;
          }

          echo json_encode(
            array(
            'fields' => $fields,
            'rows' => $rows,
            'messages' => $messages));

        } else {
          echo 'Ошибка в запросе';
        }

        $db->close();
      }
    } else {
      $messages[] = array(
        'type' => 'error',
        'text' => 'Запрошена несуществующая страница');

        echo json_encode(
          array(
            'fields' => array(),
            'rows' => array(),
            'messages' => $messages));
    }
  } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  }
