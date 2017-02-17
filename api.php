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

        include 'db/connect.php';

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
          $messages[] = array(
            'type' => 'error',
            'text' => 'Неизвестная ошибка');
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
    $messages = array();
    $success = FALSE;
    $changed_value = NULL;

    include 'db/connect.php';

    if (!isset($_SESSION)) {
      $messages[] = array(
        'type' => 'warning',
        'text' => 'Вы должны быть авторизованы, чтобы иметь возможность изменять данные');

    } else {
      $req = json_decode(file_get_contents('php://input'));

      if ($req && isset($req->type) &&
          isset($req->page) && key_exists($req->page, include 'menu_items.php') &&
          isset($req->field_name) && isset($req->new_value) && isset($req->id)) {

        if ($req->type == 'update') {
          $page = $db->real_escape_string($req->page);
          $id = $db->real_escape_string($req->id);
          $field = $db->real_escape_string($req->field_name);
          $new_value = $db->real_escape_string($req->new_value);

          //$messages[] = array(
            //'type' => 'info',
            //'text' => '' . $page . ' ' . $id . ' '. $field . ' ' . $new_value);

          $query = "UPDATE $page SET $field = '$new_value' WHERE id = $id";
          if (!$db->query($query)) {

            $messages[] = array(
              'type' => 'error',
              'text' => 'Не удалось обновить запись в таблице');

            if ($db->errno == 1452) { // foreign key constraint
              $messages[] = array(
                'type' => 'error',
                'text' => 'Операция невозможна из-за нарушения ограничения внешнего ключа');
            }

            $messages[] = array(
              'type' => 'error',
              'text' => 'Код ошибки: ' . $db->errno . ' :: ' . $db->error);

          } else {
            $query = "SELECT $field from $page WHERE id = $id";
            $result = $db->query($query);

            if ($result) {
              $success = TRUE;
              $changed_value = $result->fetch_row()[0];
            } else {
              $messages[] = array(
                'type' => 'error',
                'text' => 'Неизвестная ошибка');
            }
          }


        } else if ($req->type == 'delete') {


        } else {
          $messages[] = array(
            'type' => 'error',
            'text' => 'Ошибка запроса: неизвестная операция');
        }
      } else {
        $messages[] = array(
          'type' => 'error',
          'text' => 'Запрос сформирован некорректно');
      }
    }

    $db->close();
    echo json_encode(
      array(
        'messages' =>  $messages,
        'success' => $success,
        'changed_value' => $changed_value));
  }
