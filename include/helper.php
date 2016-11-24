<?php
  function sanitize($str) {
    return htmlentities($str, ENT_NOQUOTES, "UTF-8");
  }
  function display_errors($errors) {
    $display = '<ul class="bg-danger">';
    foreach ($errors as $error) {
      $display .= '<li class="text-danger">'.$error.'</li>';
    }
    $display .='</ul>';
    return $display;
  }
  function display_errors_special($error) {
    $display = '<ul class="bg-danger">';
    $display .= '<li class="text-danger">'.$error.'</li>';
    $display .='</ul>';
    return $display;
  }
  function login($userid) {
    $_SESSION['userid'] = $userid;
    $_SESSION['success_flash'] = "Welcome <strong>".$userid."</strong>";
    header("Location: profile.php");
  }

  function is_logged_in() {
    if (isset($_SESSION['userid'])) {
      return true;
    }
    return false;
  }
  function login_error_redirect($url = 'login.php') {
    $_SESSION['error_flash'] = 'You must be logged in.';
    header('Location: '.$url);
  }
  function password_change_success($url = 'login.php') {
    unset($_SESSION['userid']);
    $_SESSION['success_flash'] = 'Password Changed Successfully.';
    header('Location: '.$url);
  }
  function forgot_password($val){
    if ($val == 1) {
      $_SESSION['success_flash'] = 'Your password has been reset. Please check email.';
      header('Location: login.php');
    } else {
      $_SESSION['error_flash'] = 'Failed to reset password. Please try again later.';
      header('Location: login.php');
    }
  }
  function signup_success() {
    $_SESSION['success_flash'] = 'Your account has been created Successfully.';
    header('Location: login.php');
  } function edit_success() {
    $_SESSION['success_flash'] = 'Your account has been updated Successfully.';
    header('Location: profile.php');
  }
?>
