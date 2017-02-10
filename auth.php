<?php
  if (key_exists(session_name(), $_COOKIE)) {
    session_start();
  }
