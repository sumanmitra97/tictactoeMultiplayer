<?php
  require_once '../config.php';
  $userid = $_POST['userid'];
  $gameid = $_POST['gameid'];
  $return = '';
  $sql = "SELECT id, moves, first_user, second_user FROM games JOIN play WHERE id = '$gameid' AND id = game_id";
  $result = mysqli_query($db, $sql);
  if (count(mysqli_fetch_row($result)) < 1) {
    echo "9-Game Ended";
    die();
  }
  $result = mysqli_query($db, $sql);
  $game_info = mysqli_fetch_assoc($result);
  $user_no = 0;
  $moves_count = 0;
  if ($game_info['first_user'] == $userid) {
    $user_no = 1;
  } else {
    $user_no = 2;
  }
  $last_move_user_no = 0;
  $moves = $game_info['moves'];
  $flag = 1;
  if (!empty($moves)) {
    $moves_count = count(explode(',', $moves))-1;
    $ex_m = explode(',', $moves);
    $l_m = array_pop($ex_m);
    if ($l_m == '@') {
      $return = "0-Game finished.";
      $flag = 0;
    } else {
      foreach ($ex_m as $m) {
        $e_m = explode(':', $m);
        if ($e_m[1] == $_POST['grid']) {
          $flag = 0;
          $return = "0-Choose an appropiate move.";
          break;
        }
      }
    }
    $last_move = $ex_m[$moves_count-1];
    $ex_lm = explode(':', $last_move);
    $last_move_user_no = $ex_lm[0];
  }
  if ($last_move_user_no == $user_no && $last_move_user_no != 0 && $flag == 1) {
    $return = "0-Wait for your opponents move.";
  } else if ($flag == 1){
    if ($user_no == 1) {
      $moves .= "1:".$_POST['grid'].":x";
    } else {
      $moves .= "2:".$_POST['grid'].":o";
    }
    if($moves_count < 8) {
      $moves .= ",";
    } else {
      $moves .= ",@";
    }
    $moves_count += 1;
    $ex_m = explode(',', $moves);
    array_pop($ex_m);
    $w_u = 0;
    if ($moves_count > 2) {
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
      if ($w_u != 0) {
        if ($w_u == '1') {
          $u = $game_info['first_user'];
          $sql = "SELECT * FROM users WHERE id = '$u'";
          $result = mysqli_query($db, $sql);
          $user_info = mysqli_fetch_assoc($result);
          $streak = $user_info['streak'];
          $score = $user_info['score'];
          if ($streak == 4) {
            $streak = 0;
            $score += 20;
          } else {
            $streak += 1;
            $score += 10;
          }
          $sql = "UPDATE users SET score = '$score', streak = '$streak' WHERE id = '$u'";
          mysqli_query($db, $sql);
          $u = $game_info['second_user'];
          $sql = "SELECT * FROM users WHERE id = '$u'";
          $result = mysqli_query($db, $sql);
          $user_info = mysqli_fetch_assoc($result);
          $streak = 0;
          $score = $user_info['score'] - 5;
          $sql = "UPDATE users SET score = '$score', streak = '$streak' WHERE id = '$u'";
          mysqli_query($db, $sql);
        } else {
          $u = $game_info['second_user'];
          $sql = "SELECT * FROM users WHERE id = '$u'";
          $result = mysqli_query($db, $sql);
          $user_info = mysqli_fetch_assoc($result);
          $streak = $user_info['streak'];
          $score = $user_info['score'];
          if ($streak == 4) {
            $streak = 0;
            $score += 20;
          } else {
            $streak += 1;
            $score += 10;
          }
          $sql = "UPDATE users SET score = '$score', streak = '$streak' WHERE id = '$u'";
          mysqli_query($db, $sql);
          $u = $game_info['first_user'];
          $sql = "SELECT * FROM users WHERE id = '$u'";
          $result = mysqli_query($db, $sql);
          $user_info = mysqli_fetch_assoc($result);
          $streak = 0;
          $score = $user_info['score'] - 5;
          $sql = "UPDATE users SET score = '$score', streak = '$streak' WHERE id = '$u'";
          mysqli_query($db, $sql);
        }
        $moves .= '@';
      }
      if ($w_u == 0 && $moves_count == 9) {
        $u = $game_info['first_user'];
        $sql = "SELECT * FROM users WHERE id = '$u'";
        $result = mysqli_query($db, $sql);
        $user_info = mysqli_fetch_assoc($result);
        $score = $user_info['score'] + 5;
        $sql = "UPDATE users SET score = '$score', streak = 0 WHERE id = '$u'";
        mysqli_query($db, $sql);
        $u = $game_info['second_user'];
        $sql = "SELECT * FROM users WHERE id = '$u'";
        $result = mysqli_query($db, $sql);
        $user_info = mysqli_fetch_assoc($result);
        $score = $user_info['score'] + 5;
        $sql = "UPDATE users SET score = '$score', streak = 0 WHERE id = '$u'";
        mysqli_query($db, $sql);
        $return = "3-Draw";
      }
    } else {
      $return = "1-".$moves;
    }
    $sql = "UPDATE games SET moves = '$moves' WHERE id = '$gameid'";
    mysqli_query($db, $sql);
  }
  mysqli_close($db);
  echo $return;
?>
