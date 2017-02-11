<?php
  if(key_exists(session_name(), $_COOKIE)) {
    session_start();
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 1,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
    session_destroy();
    header('Location: ./index.php');
    exit;
  }
  header('Location: ./index.php');
