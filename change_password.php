<?php
  include 'include/init.php';
  include 'include/header.php';

  if(!is_logged_in()) {
    login_error_redirect();
  }
  $errors = array();
  if (isset($_GET['change']) && !empty($_GET['change'])) {
    if (!isset($_POST['old_password']) || $_POST['old_password'] == '') {
      $errors[] .= 'Please insert your current password.';
    }
    elseif (strlen($_POST['old_password']) < 7) {
      $errors[] .= 'Curent password length must be greater than 6 characters.';
    }
    else if (!isset($_POST['new_password']) || $_POST['new_password'] == '') {
      $errors[] .= 'Please insert a new password.';
    }
    elseif (strlen($_POST['new_password']) < 7) {
      $errors[] .= 'New password length must be greater than 6 characters.';
    }
    else if(!isset($_POST['confirm_password']) || $_POST['confirm_password'] == '') {
      $errors[] .= 'Please insert confirm password.';
   }
   elseif (strcmp($_POST['new_password'], $_POST['confirm_password']) <> 0) {
     $errors[] .='Password & Confirm Password does not match.' ;
   }
   elseif(strcmp($_POST['old_password'], $_POST['new_password']) == 0) {
     $errors[] .= 'Your new password can not be same as your current password.';
   }
   else{
     $old_password = trim(sanitize($_POST['old_password']));
     $new_password = trim(sanitize($_POST['new_password']));
     $userid = $_SESSION['userid'];
     $sql = "SELECT password FROM users where id = '$userid'";
     $result = mysqli_query($db,$sql);
     $userinfo = mysqli_fetch_assoc($result);
     if (!password_verify($old_password,$userinfo['password']))    {
       $errors[] .= 'Your current password is incorrect.';
     }
   }
   if (!empty($errors)) {
     echo display_errors($errors);
   }
   else{
     $hash_password =password_hash($new_password,PASSWORD_DEFAULT);
     $sql = "UPDATE users SET password = '$hash_password' WHERE id = '$userid' ";
     mysqli_query($db, $sql);
     password_change_success();
   }

}


?>


<div class="container-fluid text-center">
    <h2>Change Password</h2>
</div><hr>
<div class="container-fluid" id="login-form">
  <br>
  <form  action="change_password.php?change=1" method="post">
    <div class="form-group">
      <label for="old_password">Current Password</label>
      <input type="password" name="old_password" id="old_password" value="" class="form-control">
    </div>
    <div class="form-group">
      <label for="new_password">New Password</label>
      <input type="password" name="new_password" id="new_password" value="" class="form-control">
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm New Password</label>
      <input type="password" name="confirm_password" id="confirm_password" value="" class="form-control">
    </div>
    <button type="submit" class="btn btn-success btn-lg pull-right">Change password</button>
  </form>

</div>
<br><br><br><br><br><br><br><br>



  <?php
    include 'include/footer.php';
  ?>
