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

    $wrong_table_error = array(
      'type' => 'error',
      'text' => 'Ошибка запроса: обращение к несуществующей таблице');
    $missing_params_error = array(
      'type' => 'error',
      'text' => 'Ошибка запроса: указаны не все параметры');
    $fkey_constraint_error = array(
      'type' => 'error',
      'text' => 'Операция невозможна из-за нарушения ограничения внешнего ключа');
    $operation_fail_error = array(
      'type' => 'error',
      'text' => 'Не удалось выполнить операцию');


    include 'db/connect.php';

    if (!isset($_SESSION)) {
      $messages[] = array(
        'type' => 'warning',
        'text' => 'Вы должны быть авторизованы, чтобы иметь возможность изменять данные');

    } else {
      $req = json_decode(file_get_contents('php://input'));

      if (!$req) {
        $messages[] = array(
          'type' => 'error',
          'text' => 'Запрос сформирован некорректно');
      } else if (!isset($req->type)) {
        $messages[] = array(
          'type' => 'error',
          'text' => 'Ошибка запроса: не указан тип операции');



      } else if ($req->type == 'update') {
        if (!isset($req->page) || !isset($req->field_name) ||
            !isset($req->new_value) || !isset($req->id)) {
          $messages[] = $missing_params_error;

        } else if (!key_exists($req->page, include 'menu_items.php')) {
          $messages[] = $wrong_table_error ;

        } else {
          $page = $db->real_escape_string($req->page);
          $id = $db->real_escape_string($req->id);
          $field = $db->real_escape_string($req->field_name);
          $new_value = $db->real_escape_string($req->new_value);

          $query = "UPDATE $page SET $field = '$new_value' WHERE id = $id";
          if (!$db->query($query)) {

            $messages[] = $operation_fail_error;

            if ($db->errno == 1452) { // foreign key constraint
              $messages[] = $fkey_constraint_error;
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
        }



      } else if ($req->type == 'delete') {
        if (!isset($req->page) || !isset($req->id)) {
          $messages[] = $missing_params_error;

        } else if (!key_exists($req->page, include 'menu_items.php')) {
          $messages[] = $wrong_table_error ;

        } else {
          $page = $db->real_escape_string($req->page);
          $id = $db->real_escape_string($req->id);

          $query = "DELETE from $page WHERE id = $id";
          if (!$db->query($query)) {
            $messages[] = $operation_fail_error;

            if ($db->errno == 1452) { // foreign key constraint
              $messages[] = $fkey_constraint_error;
            }

            $messages[] = array(
              'type' => 'error',
              'text' => 'Код ошибки: ' . $db->errno . ' :: ' . $db->error);

          } else {
            $success = TRUE;
          }
        }



      } else if ($req->type == 'insert') {
        if (!isset($req->page) || !isset($req->values) || !isset($req->fields)) {
          $messages[] = $missing_params_error;

        } else if (!key_exists($req->page, include 'menu_items.php')) {
          $messages[] = $wrong_table_error;

        } else {
          $page = $req->page;
          $fields = join(",", $req->fields);
          $values = "'" . join("','", $req->values) . "'";

          $query = "INSERT INTO $page ($fields) VALUES ($values)";

          if (!$db->query($query)) {
            $messages[] = $operation_fail_error;

            $messages[] = array(
              'type' => 'error',
              'text' => 'Код ошибки: ' . $db->errno . ' :: ' . $db->error);
          } else {
            $success = TRUE;
          }
        }



      } else {
        $messages[] = array(
          'type' => 'error',
          'text' => 'Ошибка запроса: неизвестная операция');
      }
    }

    $db->close();
    echo json_encode(
      array(
        'messages' =>  $messages,
        'success' => $success,
        'changed_value' => $changed_value));
  }
