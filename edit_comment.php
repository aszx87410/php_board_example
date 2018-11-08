<?php
  include_once('./check_login.php');
  include_once('./conn.php');
  include_once('./utils.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>編輯留言</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>

  <body>
    <?php include_once('templates/navbar.php') ?>
    <div class='container'>
      <div class='form-wrapper'>
        <h1>編輯留言</h1>
        <form class='form' method='POST' action='./handle_edit_comment.php'>
            <input type='hidden' value="<?echo $_GET['id'] ?>" name="id" />
            <div class='form__row'>
              內容：
              <div>
                <textarea name='content' rows="10" cols="50"></textarea>
              </div>
            </div>

            <?php if ($user): ?>
                <input type='submit' />
            <?php else: ?>
                <div>請先註冊或登入</div>
            <?php endif; ?>
            
        </form>
      </div>
    </div>

  </body>

</html>