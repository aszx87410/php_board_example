<?php
  require_once('conn.php');
  require_once('utils.php');

  if (
    isset($_POST['content']) &&
    !empty($_POST['content'])
  ) {
      $content = $_POST['content'];
      $username = $_COOKIE['username'];

      $sql = "INSERT INTO huli_comments(username, content) VALUES('$username', '$content')";
      if ($conn->query($sql)) {
        // server redirect
        header('Location: ./index.php');
      } else {
        // client redirect
        printMessage($conn->error, './index.php'); 
      }
  } else {
    printMessage('請輸入內容！', './index.php'); 
  }
?>