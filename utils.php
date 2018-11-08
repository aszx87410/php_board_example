<?php
  function printMessage($msg, $redirect) {
    echo '<script>';
    echo "alert('" . htmlentities($msg, ENT_QUOTES) . "');";
    echo "window.location = '" . $redirect ."'";
    echo '</script>';
  }

  function setToken($conn, $username) {
    $token = uniqid();
    $sql = "DELETE FROM huli_certificates where username='$username'";
    $conn->query($sql);

    $sql = "INSERT INTO huli_certificates(username, token) VALUES('$username', '$token')";
    $conn->query($sql);
    setcookie("token", $token, time()+3600*24);
  } 

  function getUserByToken($conn, $token) {
    if (isset($token) && !empty($token)) {
      $sql = "SELECT * from huli_certificates where token='$token'";
      $result = $conn->query($sql);
      if (!$result || $result->num_rows <= 0) {
        return null;
      }
      $row = $result->fetch_assoc();
      return $row['username'];
    } else {
      return null;
    }
  }

  function renderDeleteBtn($id) {
    return "
      <div class='delete-comment'>
        <form method='POST' action='./delete_comment.php'>
            <input type='hidden' name='id' value='$id' />
            <input type='submit' value='刪除' />
        </form>
      </div>
    ";
  }

  function renderEditBtn($id) {
    return "
      <div class='edit-comment'>
        <form method='GET' action='./edit_comment.php'>
            <input type='hidden' name='id' value='$id' />
            <input type='submit' value='編輯' />
        </form>
      </div>
    ";
  }
?>