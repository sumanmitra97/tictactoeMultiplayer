<?php
include 'include/init.php';
include 'include/header.php';

if(!is_logged_in()) {
  login_error_redirect();
}
$errors = array();
$userid = $_SESSION['userid'];
$sql = "SELECT * FROM users WHERE id = '$userid'";
$result = mysqli_query($db, $sql);
$user_info = mysqli_fetch_assoc($result);
$email = (!empty($user_info['email']))?$user_info['email']:'';
$avatar = $user_info['avatar'];
if (!empty($_GET['edit']) && isset($_GET['edit'])) {
  if ($_POST['email'] == '' || !isset($_POST['email'])) {
    $errors[] .= "Please insert a valid email.";
  } elseif ($_POST['confirm_email'] == '' || !isset($_POST['confirm_email'])) {
    $errors[] .= "Please confirm email id.";
  } elseif (isset($_POST['email']) && $_POST['email'] !='' && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)===false) {
    $errors[] .='Please provide a valid email address.' ;
  } elseif ($_POST['email'] != $_POST['confirm_email']) {
    $errors[] .='Email and Confirm Email does not match.' ;
  } else {
    $email = sanitize(trim($_POST['email']));
    $avatar = sanitize($_POST['avatar_input']);
    $sql = "UPDATE users SET email = '$email', avatar = '$avatar'";
    mysqli_query($db, $sql);
    edit_success();
  }
  if (!empty($errors)) {
    echo display_errors($errors);
  }
}
?>
<div class="flash">
  <?=$flash;?>
</div>
<div class="conatiner text-center">
  <h2>Edit Profile</h2>
</div>
<div class="container" id="login-form">
  <br>
  <form action="edit_profile.php?edit=1" method="post">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group">
      <label for="confirm_email">Confirm Email</label>
      <input type="email" name="confirm_email" id="confirm_email" class="form-control" value="<?=(isset($_POST['confirm_email']))?$_POST['confirm_email']:$email;?>">
    </div>
    <div class="form-group">
      <label>Choose an Avatar*</label><br><br>
      <input type="number" id="avatar_input" name="avatar_input" value="<?=$avatar;?>" hidden>
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
      <button type="submit" class="btn btn-success form-control">Update</button>
    </div>
  </form>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    choose_avatar($("#avatar_input").val());
    setTimeout(remove_flash, 5000);
  });
</script>
<?php
  include 'include/footer.php';
?>
