<?php
  include_once('./check_login.php');
  include_once('./conn.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>

  <body>
    <?php include_once('templates/navbar.php') ?>
    <div class='container'>
      <div class='form-wrapper'>
        <h1>新增留言</h1>
        <form class='form' method='POST' action='./add_comment.php'>
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
      <div class='comments'>
          <?php
            $sql = "
              SELECT c.content, c.created_at, u.nickname
              FROM huli_comments as c
              LEFT JOIN huli_users as u ON c.username = u.username
              ORDER BY c.id DESC
            ";
            $result = $conn->query($sql);

            if ($result) {
              while($row = $result->fetch_assoc()) {
                ?>
                  <div class='comment'>
                    <div class='comment__author'>作者：<?= $row['nickname'] ?></div>
                    <div class='comment__content'><?= $row['content'] ?></div>
                    <div class='comment__time'>發言時間：<?= $row['created_at']?></div>
                </div>
                <?php
              }
            }

          ?>
      </div>
    </div>

  </body>

</html>