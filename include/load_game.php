<?php
  require_once '../config.php';
  $gameid = (int)$_POST['gameid'];
  $sql = "SELECT id, moves, first_user, second_user FROM games JOIN play WHERE id = '$gameid' AND id = game_id";
  $result = mysqli_query($db, $sql);
  if (count(mysqli_fetch_row($result)) < 1) {
    echo "9-Game Ended";
    die();
  }
  $result = mysqli_query($db, $sql);
  $game_info = mysqli_fetch_assoc($result);
  $moves = $game_info['moves'];
  $return = "";
  if (!empty($moves)) {
    $ex_m = explode(',', $moves);
    $l_m = array_pop($ex_m);
    $moves_count = count($ex_m);
    $w_u = 0;
    if ($l_m == '@') {
      $grids = array_fill(0, 9, 0);
      foreach ($ex_m as $m) {
        $e_m = explode(':', $m);
        $grids[$e_m[1]-1] = $e_m[0];
      }
      if (($grids[0] == '1' && $grids[1] == '1' && $grids[2] == '1') || ($grids[0] == '2' && $grids[1] == '2' && $grids[2] == '2')) {
        $return = "2-1:3:";
        if ($grids[0] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[0];
      } elseif (($grids[3] == '1' && $grids[4] == '1' && $grids[5] == '1') || ($grids[3] == '2' && $grids[4] == '2' && $grids[5] == '2')) {
        $return = "2-4:6:";
        if ($grids[3] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[3];
      } elseif (($grids[6] == '1' && $grids[7] == '1' && $grids[8] == '1') || ($grids[6] == '2' && $grids[7] == '2' && $grids[8] == '2')) {
        $return = "2-7:9:";
        if ($grids[6] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[6];
      } elseif (($grids[0] == '1' && $grids[3] == '1' && $grids[6] == '1') || ($grids[0] == '2' && $grids[3] == '2' && $grids[6] == '2')) {
        $return = "2-1:7:";
        if ($grids[0] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[0];
      } elseif (($grids[1] == '1' && $grids[4] == '1' && $grids[7] == '1') || ($grids[1] == '2' && $grids[4] == '2' && $grids[7] == '2')) {
        $return = "2-2:8:";
        if ($grids[1] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[1];
      } elseif (($grids[2] == '1' && $grids[5] == '1' && $grids[8] == '1') || ($grids[2] == '2' && $grids[5] == '2' && $grids[8] == '2')) {
        $return = "2-3:9:";
        if ($grids[2] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[2];
      } elseif (($grids[0] == '1' && $grids[4] == '1' && $grids[8] == '1') || ($grids[0] == '2' && $grids[4] == '2' && $grids[8] == '2')) {
        $return = "2-1:9:";
        if ($grids[0] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[0];
      } elseif (($grids[2] == '1' && $grids[4] == '1' && $grids[6] == '1') || ($grids[2] == '2' && $grids[4] == '2' && $grids[6] == '2')) {
        $return = "2-3:7:";
        if ($grids[2] == 1) {
          $return .= $game_info['first_user'];
        } else {
          $return .= $game_info['second_user'];
        }
        $w_u = $grids[2];
      }
      $mov = implode(',', $ex_m);
      $return .= "-".$mov;
    }
    if ($w_u == 0 && $l_m == '@') {
      $return = "3-".implode(',', $ex_m);
    } else if ($l_m == '' && $w_u == 0) {
      $return = "1-".implode(',', $ex_m);
    }
  } else {
    $return = "0-Empty";
  }
  mysqli_close($db);
  echo $return;
?>
