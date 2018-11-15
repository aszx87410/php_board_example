<?php
  session_start(); // 1. 可以從 cookie 裡面拿到 PHPSESSID
  include_once('./conn.php');
  include_once('./utils.php');

  // 2. 拿 PHPSSESID 去查
  /*
    {
      'a164347b69a1bf4e9c3e867d2f7eecb2': {
        username: $username
      }
    }
  */
  $user = $_SESSION['username'];
?>