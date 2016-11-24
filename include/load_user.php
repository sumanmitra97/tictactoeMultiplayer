<?php
  require_once '../config.php';
  if ($_POST['gameid'] != '') {
    $gameid = (int)$_POST['gameid'];
    $sql = "SELECT * FROM play WHERE game_id = '$gameid'";
    $result = mysqli_query($db, $sql);
    $game_info = mysqli_fetch_assoc($result);
    if (!empty($game_info['second_user'])) {
      echo "1-".$game_info['second_user'];
    }
  }
?>
