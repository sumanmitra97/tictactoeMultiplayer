<?php
  require_once 'config.php';
  include 'include/helper.php';
  $flash = '';
  session_start();

  if (isset($_SESSION['success_flash'])) {
    $flash = '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
    unset($_SESSION['success_flash']);
  }
  if (isset($_SESSION['error_flash'])) {
    $flash = '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
    unset($_SESSION['error_flash']);
  }


?>
