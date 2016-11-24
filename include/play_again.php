<?php
  require_once '../config.php';
  $gameid = $_POST['gameid'];
  $sql = "UPDATE games SET moves= NULL WHERE id = '$gameid'";
  mysqli_query($db, $sql);
  mysqli_close($db);
?>
