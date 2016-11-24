<?php
  include 'include/init.php';
  include 'include/header.php';

  if(is_logged_in()) {
    header('Location:game.php');
  }
  $errors = array();

  if (isset($_GET['login']) && !empty($_GET['login'])) {
    if (!isset($_POST['username']) || $_POST['username'] == '') {
      $errors[] .= 'Please insert a username.';
    } elseif (!isset($_POST['password']) || $_POST['password'] == ''){
      $errors[] .= 'Please insert your password.';
    } elseif (!ctype_alnum($_POST['username'])){
      $errors[] .= 'Username should contain alphanumeric characters only.';
    } elseif (strlen($_POST['password']) < 7) {
      $errors[] .= 'Password length must be greater than 6 characters.';
    } else {
      $username = trim(sanitize($_POST['username']));
      $password = trim(sanitize($_POST['password']));
      $sql = "SELECT * FROM users WHERE id = '$username'";
      $result = mysqli_query($db, $sql);
      $rows = mysqli_fetch_row($result);
      $result = mysqli_query($db, $sql);
      $userinfo = mysqli_fetch_assoc($result);
      if ($rows < 1) {
        $errors[] .= 'The username does not exist. Please provide a correct username.';
      } else if (!password_verify($password, $userinfo['password'])) {
        $errors[] .= 'Incorrect password inserted. Please provide the correct password.';
      }
    }
    if (!empty($errors)) {
      echo display_errors($errors);
    } else {
      login($userinfo['id']);
    }

  }
?>
<div class="flash">
  <?= $flash; ?>
</div>
<div class="conatiner text-center">
  <h2>Login</h2>
</div><hr>
<div class="container" id="login-form">
  <br>
  <form action="login.php?login=1" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input class="form-control" type="text" name="username" id="username" value="<?=((isset($_POST['username']) && !empty($_POST['username']))?$_POST['username']:''); ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input class="form-control" type="password" name="password" id="password" value="">
    </div>
    <br>
    <button type="submit" class="btn btn-success pull-right">Login</button>
    <br><br>
    <a href="forgot_password.php" class="btn btn-primary">Forgot Password</a>
    <a href="signup.php" class="btn btn-primary">Sign Up</a>

  </form>
</div>
<br><br><br><br><br><br><br><br>
<?php
  include 'include/footer.php';
?>
