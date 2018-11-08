<?php
  include_once('./check_login.php');
  include_once('./conn.php');
  include_once('./utils.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>

  <body>
    <?php include_once('templates/navbar.php') ?>
    <?php 
      // 1 => 0
      // 2 => $size
      $page = 1;
      if (isset($_GET['page']) && !empty($_GET['page'])) {
        $page = (int) $_GET['page'];
      }
      $size = 3;
      $start = $size * ($page - 1);
      $sql = "
        SELECT c.id, c.content, c.created_at, c.username, u.nickname
        FROM huli_comments as c
        LEFT JOIN huli_users as u ON c.username = u.username
        WHERE c.parent_id = 0
        ORDER BY c.id DESC
        LIMIT $start, $size
      ";

      $result = $conn->query($sql);
    ?>
    <div class='container'>
      <div class='form-wrapper'>
        <h1>新增留言</h1>
        <form class='form' method='POST' action='./add_comment.php'>
            <input type='hidden' value="0" name="parent_id" />
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
      <?php
          $count_sql = "SELECT count(*) as count FROM huli_comments where parent_id=0";
          $count_result = $conn->query($count_sql);
          if ($count_result && $count_result->num_rows > 0) {
            $count = $count_result->fetch_assoc()['count'];
            $total_page = ceil($count / $size);
            echo '<div class="page">';
            for($i=1; $i<=$total_page; $i++) {
              echo "<a href='./index.php?page=$i'>$i</a>";
            }
            echo '</div>';
          }

      ?>
      <div class='comments'>
          <?php
            if ($result) {
              while($row = $result->fetch_assoc()) {
                ?>
                  <div class='comment'>
                    <div class='comment__author'>作者：<?= $row['nickname'] ?></div>
                    <div class='comment__content'><?= $row['content'] ?></div>
                    <div class='comment__time'>發言時間：<?= $row['created_at']?></div>

                    <?php
                      if ($user === $row['username']) {
                        echo renderEditBtn($row['id']);
                        echo renderDeleteBtn($row['id']);
                      }
                    ?>

                    <div class="sub-comments">
                      <?php
                        $parent_id = $row['id'];
                        $sql_sub = "
                          SELECT c.id, c.content, c.created_at, c.username, u.nickname
                          FROM huli_comments as c
                          LEFT JOIN huli_users as u ON c.username = u.username
                          WHERE c.parent_id = $parent_id
                          ORDER BY c.id DESC
                        ";
                        $result_sub = $conn->query($sql_sub);

                        if ($result_sub) {
                          while($row_sub = $result_sub->fetch_assoc()) {
                      ?>
                        <div class="sub-comment">
                            <div class="sub-comment__author">作者：<?= $row_sub['nickname'] ?></div>
                            <div class="sub-comment__content"><?= $row_sub['content'] ?></div>
                            <div class="sub-comment__time">發言時間：<?= $row_sub['created_at']?></div>
                            <?php
                              if ($user === $row_sub['username']) {
                                echo renderEditBtn($row_sub['id']);
                                echo renderDeleteBtn($row_sub['id']);
                              }
                            ?>
                        </div>
                      <?php
                          }
                        }
                      ?>
                      <div class="add-sub-comment">
                          <h3>新增留言</h3>
                          <form method='POST' action='./add_comment.php'>
                            <input type='hidden' value="<?php echo $parent_id; ?>" name="parent_id" />
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
                </div>
                <?php
              }
            }

          ?>
      </div>
    </div>

  </body>

</html>