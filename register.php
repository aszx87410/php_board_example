<!DOCTYPE html>
<html>
  <head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>

  <body>
    <?php include_once('templates/navbar.php')  ?>
    <div class='container'>
        <div class='form-wrapper'>
          <form class='form' method='POST' action='./handle_register.php'>
              <div class='form__row'>
                暱稱：<input type='text' name='nickname' />
              </div>
              <div class='form__row'>
                帳號：<input type='text' name='username' />
              </div>
              <div class='form__row'>
                密碼：<input type='password' name='password' />
              </div>
              <input type='submit' />
          </form>
        </div>
    </div>

  </body>

</html>