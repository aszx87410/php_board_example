<?php
  session_start(); // 1. 產生 session id，放到 cookie
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
      
      $stmt = $conn->prepare("SELECT * from huli_users where username=?");
      $stmt->bind_param("s", $username);
      if (!$stmt->execute()) {
        echo $conn->error;
        // printMessage($conn->error, './login.php');
        exit();
      }
      $result = $stmt->get_result();
      if ($result->num_rows <= 0) {
        printMessage('帳號或密碼錯誤', './login.php'); 
        exit();
      }

      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        // 2. $username 放到記憶體裡面去
        /*
            {
              'a164347b69a1bf4e9c3e867d2f7eecb2': {
                username: $username
              }
            }
        */
        $_SESSION['username'] = $username;
        printMessage('登入成功！', './index.php');
      } else {
        printMessage('帳號或密碼錯誤', './login.php'); 
        exit();
      }
  } else {
    printMessage('請輸入帳號或是密碼!', './login.php'); 
  }
?>