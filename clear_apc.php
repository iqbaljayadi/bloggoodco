<?php
header("Cache-Control: private");

if ($_GET['token'] != 'w3secret') {
    header("HTTP/1.0 404 Not Found");
    exit;
}

  apc_clear_cache();
  apc_clear_cache('user');
  apc_clear_cache('opcode');
  echo json_encode(array('success' => true));

?>