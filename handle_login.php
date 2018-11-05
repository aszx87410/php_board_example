<?php
  require_once('conn.php');
  require_once('utils.php');

  if (
    isset($_POST['username']) && 
    isset($_POST['password']) &&
    !empty($_POST['username']) &&
    !empty($_POST['password'])
  ) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      
      $sql = "SELECT * from huli_users where username='$username' and password = '$password'";

      $result = $conn->query($sql);
      if (!$result) {
        printMessage($conn->error, './login.php');
        exit();
      }

      if ($result->num_rows > 0) {
        setcookie("username", $username, time()+3600*24);
        printMessage('登入成功！', './index.php');
      } else {
        printMessage('帳號或密碼錯誤', './login.php'); 
      }
  } else {
    printMessage('請輸入帳號或是密碼!', './login.php'); 
  }
?>