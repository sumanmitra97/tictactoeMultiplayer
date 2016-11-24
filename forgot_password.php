<?php
  include 'include/init.php';
  include 'include/header.php';

  if(is_logged_in()) {
    header('Location:game.php');
  }
  $errors = array();

  if (isset($_GET['forgot']) && !empty($_GET['forgot'])) {
    if (!isset($_POST['username']) || $_POST['username'] == '') {
      $errors[] .= 'Please insert a username.';
    } elseif (!isset($_POST['email']) || $_POST['email'] == ''){
      $errors[] .= 'Please insert your email.';
    } elseif (!ctype_alnum($_POST['username'])){
      $errors[] .= 'Username should contain alphanumeric characters only.';
    }  else {
      $username = trim(sanitize($_POST['username']));
      $email = trim(sanitize($_POST['email']));
      $sql = "SELECT * FROM users WHERE id = '$username'";
      $result = mysqli_query($db, $sql);
      $rows = mysqli_fetch_row($result);
      $result = mysqli_query($db, $sql);
      $userinfo = mysqli_fetch_assoc($result);
      if ($rows < 1) {
        $errors[] .= 'The username does not exist. Please provide a correct username.';
      } else if (strcmp($email,$userinfo['email'])) {
        $errors[] .= 'The email does not match with the username.';
      }
    }
    if (!empty($errors)) {
      echo display_errors($errors);
    } else {
      $to = $userinfo['email'];
      $subject = 'tictactoe Multiplayer - Password Reset';
      $password = mt_rand(1000000, 99999999);
      $message = 'Your username: '.$username."\r\n".'Your password: '.$password;
      $hash_password = password_hash($password, PASSWORD_DEFAULT);
      $headers = '';
      if (mail($to,$subject,$message,$headers)){
        $sql = "UPDATE users SET password = '$hash_password' WHERE id = '$username'";
        mysqli_query($db,$sql);
        forgot_password(1);
      } else {
        forgot_password(0);
      }
    }
  }
?>

<div class="container-fluid text-center">
  <h2>Forgot Password</h2>

</div><br>
<div class="container-fluid" id="login-form">
  <br>
  <form action="forgot_password.php?forgot=1" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input class="form-control" type="text" name="username" id="username" value="<?=((isset($_POST['username']) && !empty($_POST['username']))?$_POST['username']:''); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input class="form-control" type="email" name="email" id="email" value="<?=((isset($_POST['email']) && !empty($_POST['email']))?$_POST['email']:''); ?>">
    </div>
    <br>
    <button type="submit" class="btn btn-success btn-lg pull-right">Submit</button>
  </form>
</div>
<br><br><br><br><br><br><br><br>
<?php
  include 'include/footer.php';
?>
