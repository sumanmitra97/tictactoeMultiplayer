<?php
  include 'include/init.php';
  include 'include/header.php';

  if(is_logged_in()) {
    header('Location:game.php');
  }
  $errors = array();
  if (isset($_GET['signup']) && !empty($_GET['signup'])) {
    if(!isset($_POST['username']) || $_POST['username']=='') {
      $errors[] .= 'Please enter your username.' ;
    }
    else if ($_POST['avatar_input']=='0') {
      $errors[] .= 'Please Choose an Avatar.' ;
    }
    else if(!isset($_POST['password']) || $_POST['password']=='') {
      $errors[] .= 'Please enter your password.' ;
    }
    else if(!isset($_POST['confirm_password']) || $_POST['confirm_password']=='') {
      $errors[] .= 'Please confirm your password.' ;
    }
    else if(!ctype_alnum($_POST['username'])) {
      $errors[] .='Username should contain alphanumeric characters only.';
    }
    else if(strlen($_POST['password']) < 7) {
      $errors[] .='Password length should contain minimum 7 characters.' ;
    }
    else if(strcmp($_POST['password'], $_POST['confirm_password']) != 0) {
      $errors[] .='Password & Confirm Password does not match.' ;
    }
    else if(isset($_POST['email']) && $_POST['email'] !='' && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)===false) {
      $errors[] .='Please provide a valid email address.' ;
    }
    else if ($_POST['password'] == $_POST['username'] || $_POST['password'] == $_POST['email']) {
      $errors[] .='Password can not be same as username or email.' ;
    }
    else{
      $username = trim(sanitize($_POST['username']));
      $password = trim(sanitize($_POST['password']));
      $email = ((isset($_POST['email']) && $_POST['email']!='')?trim(sanitize($_POST['email'])):NULL);
      $avatar_input = trim(sanitize($_POST['avatar_input']));
      $sql = "SELECT * FROM users WHERE id = '$username'";
      $result = mysqli_query($db,$sql);
      $rows = mysqli_fetch_row($result);
      if ($rows > 0) {
        $errors[] .='The username already exists.' ;
      }
    }
    if (!empty($errors)) {
      echo display_errors($errors);
    }
    else {
      $hash_password = password_hash($password,PASSWORD_DEFAULT);
      $sql= "INSERT INTO users (id,password,avatar,score,streak,email) VALUES ('$username','$hash_password','$avatar_input',100,0,";
      if ($email == NULL) {
        $sql .= "NULL)";
      } else {
        $sql .= "'$email')";
      }
      mysqli_query($db,$sql);
      signup_success();
    }
  }
?>
<div class="conatiner-fluid text-center">
  <h2>Signup</h2>
</div><hr><br>
<div class="container">
  <ul class="bg-info" style="list-style-type: square; border-radius: 20px; text-align: center; font-size: 16px;">
    <li style="color: #004a7c;">The Email address is used for password reset purposes only.</li>
    <li style="color: #004a7c;">No spam message will be sent to your email address.</li>
  </ul>
</div><br>
<div class="container-fluid" id="login-form">
  <br>
  <form action="signup.php?signup=1" method="post">
    <div class="form-group">
      <label for="username">Username*</label>
      <input class="form-control" type="text" name="username" id="username" value="<?=((isset($_POST['username']) && !empty($_POST['username']))?$_POST['username']:''); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" class="form-control" value="<?= ((isset($_POST['email']) && !empty ($_POST['email']))?$_POST['email']:'') ; ?>">
    </div>
    <div class="form-group">
      <label for="password">Password*</label>
      <input class="form-control" type="password" name="password" id="password" value="">
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm Password*</label>
      <input class="form-control" type="password" name="confirm_password" id="confirm_password" value="">
    </div>
    <div class="form-group">
      <label>Choose an Avatar*</label><br><br>
      <input type="number" id="avatar_input" name="avatar_input" value="0" hidden="true">
      <div class="row">
        <div class="col-xs-3">
          <img src="images/1.PNG" alt="Avatar" onclick="choose_avatar(1)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_1"/>
        </div>
        <div class="col-xs-3">
          <img src="images/2.PNG" alt="Avatar" onclick="choose_avatar(2)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_2"/>
        </div>
        <div class="col-xs-3">
          <img src="images/3.PNG" alt="Avatar" onclick="choose_avatar(3)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_3"/>
        </div>
        <div class="col-xs-3">
          <img src="images/4.PNG" alt="Avatar" onclick="choose_avatar(4)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_4"/>
        </div>
      </div><br>
      <div class="row">
        <div class="col-xs-3">
          <img src="images/5.PNG" alt="Avatar" onclick="choose_avatar(5)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_5"/>
        </div>
        <div class="col-xs-3">
          <img src="images/6.PNG" alt="Avatar" onclick="choose_avatar(6)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_6"/>
        </div>
        <div class="col-xs-3">
          <img src="images/7.PNG" alt="Avatar" onclick="choose_avatar(7)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_7"/>
        </div>
        <div class="col-xs-3">
          <img src="images/8.PNG" alt="Avatar" onclick="choose_avatar(8)" class="img-responsive" style="width: 100px; height: auto; border-radius: 10px;" id="img_8"/>
        </div>
      </div>
    </div>
    <p class="help-block">*Fields are required.</p>
    <br>
    <div class="form-group">
      <button type="submit" class="btn btn-success form-control">Signup</button>
    </div>
  </form>
</div>
<br>

<br><br><br><br><br><br><br><br>
<?php
  include 'include/footer.php';
?>
