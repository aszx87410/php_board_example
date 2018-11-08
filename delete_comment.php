<?php
  include_once('check_login.php');
  require_once('conn.php');
  require_once('utils.php');

  if (
    isset($_POST['id']) &&
    !empty($_POST['id'])
  ) {
      $id = $_POST['id'];

      $sql = "DELETE FROM huli_comments where id=$id or parent_id=$id";
      if ($conn->query($sql)) {
        // server redirect
        header('Location: ./index.php');
      } else {
        // client redirect
        printMessage($conn->error, './index.php'); 
      }
  } else {
    printMessage('錯誤', './index.php'); 
  }
?>