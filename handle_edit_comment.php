<?php
  include_once('check_login.php');
  require_once('conn.php');
  require_once('utils.php');

  if (
    isset($_POST['content']) &&
    !empty($_POST['content'])
  ) {
      $content = $_POST['content'];
      $id = $_POST['id'];

      $sql = "UPDATE huli_comments SET content = ? WHERE id = ? AND username = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sis", $content, $id, $user);
      if ($stmt->execute()) {
        header('Location: ./index.php');
      } else {
        printMessage($conn->error, $_SERVER["HTTP_REFERER"]); 
      }
  } else {
    printMessage('請輸入內容！', $_SERVER["HTTP_REFERER"]); 
  }
?>