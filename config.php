<?php
  $host = 'localhost';
  $user =  'root';
  $password = '';
  $database = 'tictactoe';
  $db = mysqli_connect($host, $user, $password, $database);
  if (mysqli_connect_errno()) {
    echo "Something went wrong: ".mysqli_connect_errno()."-".mysqli_connect_error();
    die();
  }
?>
