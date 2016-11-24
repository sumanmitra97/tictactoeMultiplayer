<?php
  require_once '../config.php';
  $gameid = $_POST['gameid'];
  $sql = "SELECT * FROM games WHERE id = '$gameid'";
  $result = mysqli_query($db, $sql);
  if (count(mysqli_fetch_row($result)) < 1) {
    die();
  }
  $sql = "DELETE FROM games WHERE id = '$gameid'";
  mysqli_query($db, $sql);
  $sql = "DELETE FROM play WHERE game_id = '$gameid'";
  mysqli_query($db, $sql);
  mysqli_close($db);
?>
