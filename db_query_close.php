<?php
  $result = $db->query($query);

  $db->close();

  return $result;
