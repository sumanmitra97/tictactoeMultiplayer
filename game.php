<?php
  include 'include/init.php';
  include 'include/header.php';
  if(!is_logged_in()) {
    login_error_redirect();
  }
if(isset($_SESSION['errors'])) {
  echo display_errors_special($_SESSION['errors']);
  unset($_SESSION['errors']);
}
if (isset($_GET['game']) && !empty($_GET['game'])){
  $game=(int)trim(sanitize($_GET['game']));
  if ($game==1){
    $userid = $_SESSION['userid'];
    $gameid = mt_rand(0, 99999999);
    $sql = "SELECT id FROM games WHERE id = '$gameid'";
    $result = mysqli_query($db, $sql);
    if (mysqli_fetch_row($result) <> 0) {
      $gameid = mt_rand(0, 99999999);
      $sql = "SELECT id FROM games WHERE id = '$gameid'";
      $result = mysqli_query($db, $sql);
    }
    $sql = "INSERT INTO games (id) VALUES ('$gameid')";
    mysqli_query($db, $sql);
    $sql = "INSERT INTO play (game_id, first_user) VALUES ('$gameid', '$userid')";
    mysqli_query($db, $sql);
    header("location: game.php?game=".$gameid);
  }
  elseif ($game==2) {
    unset($_SESSION['gameid']);
    if ($_POST['gameid'] != '' && !empty($_POST['gameid'])) {
      $_SESSION['gameid'] = $_POST['gameid'];
    }
    if (!isset($_POST['gameid']) || empty($_POST['gameid'])) {
      $_SESSION['errors'] ='Please start a new game or join a game.' ;
      header('location:game.php');
    }
    else{
      $gameid = trim(sanitize($_POST['gameid']));
      $sql = "SELECT id FROM games WHERE id ='$gameid'";
      $result = mysqli_query($db,$sql);
      $sql="SELECT * FROM play WHERE game_id = '$gameid' ";
      $result2 = mysqli_query($db,$sql);
      $game_info = mysqli_fetch_assoc($result2);
      $userid = $_SESSION['userid'];
      if(mysqli_fetch_row($result) == 0) {
        $_SESSION['errors'] ='Please insert correct id.';
        header('location:game.php');
      }
      elseif (!empty($game_info['second_user'])) {
        $_SESSION['errors'] = 'This game already has two players.';
        header('location:game.php');
      }
      elseif ($game_info['first_user']==$userid) {
        $_SESSION['errors'] = 'Two players can not be same.';
        header('location:game.php');
      }
      else {
        $sql = "UPDATE play SET second_user = '$userid' WHERE game_id = '$gameid'";
        mysqli_query($db, $sql);
        header("location: game.php?game=".$gameid);
      }
    }
  } else {
    $gameid = (int)trim(sanitize($_GET['game']));
    $sql = "SELECT * FROM play WHERE game_id = '$gameid'";
    $result = mysqli_query($db, $sql);
    $game_info = mysqli_fetch_assoc($result);
    $userid = $_SESSION['userid'];
    if ($game_info['game_id'] != $gameid) {
      $_SESSION['errors'] = 'Please provide a valid game id.';
      header('location:game.php');
    } else {
      if($userid != $game_info['second_user'] && $userid != $game_info['first_user']) {
        $_SESSION['errors'] = 'Please insert another game id.';
        header('location:game.php');
      } else {
        $f = $game_info['first_user'];
        $s = $game_info['second_user'];
        $sql = "SELECT * FROM users WHERE id = '$f'";
        $result = mysqli_query($db, $sql);
        $first_user_info = mysqli_fetch_assoc($result);
        $second_user_check = 0;
        $first_user_level=(int)($first_user_info['score']/100);
        $first_user_p=(int)($first_user_info['score']%100);
        $first_user_a = (int)$first_user_info['avatar'];
        if (!empty($game_info['second_user'])) {
          $second_user_check = 1;
          $sql = "SELECT * FROM users WHERE id = '$s'";
          $result = mysqli_query($db, $sql);
          $second_user_info = mysqli_fetch_assoc($result);
          $second_user_level=(int)($second_user_info['score']/100);
          $second_user_p=(int)($second_user_info['score']%100);
          $second_user_a = (int)$second_user_info['avatar'];
        }

      }
    }
  }
?>
<!-- Game html -->

<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="well well-sm" id="game-well" style="margin: auto;">
        <form>
          <div class="form-group text-center">
            <label>Game ID</label>
            <input type="text" class="form-control" id="gameid" value="<?=$gameid;?>" readonly style="background-color:white; text-align: center;">
            <?php if ($second_user_check == 0): ?>
              <p class="help-block"><strong>Share this ID with a friend to add to Game.</strong></p>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
  <hr>
  <div class="row">
    <div class="col-xs-4">
      <img alt="<?=$first_user_info['id'];?>" id="avatar" src="images/<?=$first_user_a;?>.PNG" class="img-rounded">
      <h5 class="text-danger">
        <strong><?=$first_user_info['id'];?></strong>
      </h5>
      <h5 class="text-info">
        <strong>Level: </strong><?=$first_user_level;?>
     </h5>
     <div class="progress">
       <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?=$first_user_p;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=$first_user_p;?>%;">
           <?=$first_user_info['score'];?>
       </div>
     </div>
     <h5 class="text-success">Streak</h5>
     <div class="progress">
       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=($first_user_info['streak']*25);?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=($first_user_info['streak']*25);?>%;">
           <?=$first_user_info['streak'];?>
       </div>
     </div>
    </div>
    <div class="col-xs-4"></div>
    <?php if ($second_user_check != 0): ?>
      <div class="col-xs-4" id="profile-right">
        <img alt="<?=$second_user_info['id'];?>" id="avatar" src="images/<?=$second_user_a;?>.PNG" class="img-rounded">
        <h5 class="text-danger">
          <strong><?=$second_user_info['id'];?></strong>
        </h5>
        <h5 class="text-info">
        <strong>Level: </strong><?=$second_user_level;?>
      </h5>
       <div class="progress">
         <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?=$second_user_p;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=$second_user_p;?>%;">
             <?=$second_user_info['score'];?>
         </div>
       </div>
       <h5 class="text-success">Streak</h5>
       <div class="progress">
         <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=($second_user_info['streak']*25);?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=($second_user_info['streak']*25);?>%;">
             <?=$second_user_info['streak'];?>
         </div>
       </div>
     </div>
   <?php else: ?>
     <div class="col-xs-4"></div>
   <?php endif; ?>

  </div>
  <hr>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div>
        <input type="text" id="userid" value="<?=$_SESSION['userid'];?>" hidden>
        <input type="text" id="second_user_check" value="<?=$second_user_check;?>" hidden>
        <p id="notify" class="text-center text-info bg-info" style="border-radius: 5px;"></p>
      </div>
      <canvas id="canvas" width="1200" height="1200" onmousedown="make_move(event)">
        Sorry, your browser doesn't support the &lt;canvas&gt; element.
      </canvas>
    </div>
    <div class="col-md-3"></div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 text-center">
      <button type="button" name="button" class="btn btn-danger btn-lg" id="btn-game-trigger" onclick="end_game('profile.php')">End Game</button>
      <button type="button" name="button" class="btn btn-success btn-lg" id="btn-game-trigger" onclick="play_again()">Play Again</button>
    </div>
    <div class="col-md-3"></div>
  </div>
  <div>
    <p id="test_bed"></p>
  </div>
</div>

<?php
}
else {

?>
<div class="conatiner text-center">
  <h2>Start your game</h2>
</div><hr>
<div class="container" id="game_form">
  <form action="game.php?game=1" method="post">
    <!-- Create Game -->
    <br>
    <button type="submit" class="btn btn-primary btn-lg form-control" id="create-btn">Start a new game</button>

  </form>
  <hr>
  <form action="game.php?game=2" method="post">
    <!-- Join game-->
    <div class="form-group" id="join_form">
      <label for="gameid" id="join_label">Join game</label>
      <input type="number" name="gameid" id="gameid" class="form-control" value="<?= ((isset($_SESSION['gameid']) && !empty($_SESSION['gameid']))?$_SESSION['gameid']:''); ?>">
    </div>
    <button type="submit" class="btn btn-success btn-lg form-control" id="join_btn">Join</button>
    <br><hr>
  </form>
</div>

<?php
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    var canvas = document.getElementById("canvas");
  });
  setInterval(function(){
    if ($("#second_user_check").val() == 0) {
      load_user($("#gameid").val());
    }
    load_moves(canvas);
  }, 2500);
  draw_canvas(canvas);
</script>

<?php

  include 'include/footer.php';
?>
