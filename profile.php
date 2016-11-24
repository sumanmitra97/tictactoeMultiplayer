<?php
  include 'include/init.php';
  include 'include/header.php';

  if(!is_logged_in()) {
    login_error_redirect();
  }
  if (!empty($_GET['end']) && $_GET['end'] != '') {
    $flash = "<div class='bg-danger'><p class='text-danger text-center'>Game <strong>".sanitize($_GET['end'])."</strong> finished!</p></div>";
  }
  $userid = $_SESSION['userid'];
  $sql = "SELECT * FROM users WHERE id = '$userid'";
  $result = mysqli_query($db, $sql);
  $user_info = mysqli_fetch_assoc($result);
  $user_level=(int)($user_info['score']/100);
  $user_p=(int)($user_info['score']%100);
  $sql = "SELECT * FROM play WHERE first_user = '$userid' OR second_user = '$userid'";
  $result = mysqli_query($db, $sql);
?>
<div class="flash">
  <?= $flash; ?>
</div>
<div class="container">
  <br>
  <h2 class="text-center">Your Games</h2>
  <hr>
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-xs-6">
          <img src="images/<?=$user_info['avatar'];?>.PNG" alt="<?=$user_info['id'];?>" class="img-responsive" style="width: 150px; height: auto; border-radius: 10px;"/>
        </div>
        <div class="col-xs-6" style="margin-top: 10px; margin-left: -20px;">
          <h3 class="text-danger"><strong><?=$user_info['id'];?></strong></h3>
          <h4 class="text-info" style="margin-top: 20px;"><strong>Level</strong>: <?=$user_level;?></h4>
        </div>
      </div>
      <h4 class="text-info" style="text-align: right"><strong>Score</strong></h4>
      <div class="progress">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?=$user_p;?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=$user_p;?>%;">
            <?=$user_info['score'];?>
        </div>
      </div>
      <h4 class="text-success" style="text-align: right"><strong>Streak</strong></h4>
      <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=($user_info['streak']*25);?>" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: <?=($user_info['streak']*25);?>%;">
            <?=$user_info['streak'];?>
        </div>
      </div>
    </div>
    <div class="col-md-8" style="padding: 10px 0px;">
      <table class="table table-condensed table-hover table-bordered" style="width: 90%; height: auto; margin: auto;">
        <tr>
          <th class="bg-success text-info" style="text-align: center; font-size: 16px;">Game-ID</th>
          <th class="bg-success text-info" style="text-align: center; font-size: 16px;">Against</th>
          <th class="bg-success text-info" style="text-align: center; font-size: 16px;">End</th>
        </tr>
        <?php while ($play_info = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td style="text-align: center;">
              <a href="game.php?game=<?=$play_info['game_id'];?>" role="button" class="btn btn-info" style="width: 90%; height: auto;"><?=$play_info['game_id'];?></a>
            </td>
            <td style="text-align: center;">
              <?php
              if ($play_info['first_user'] == $userid) {
                if (!empty($play_info['second_user'])) {
                  $against = $play_info['second_user'];
                } else {
                  $against = 'Add opponent';
                }
              ?>
                <a href="game.php?game=<?=$play_info['game_id'];?>" role="button" class="btn btn-success" style="width: 90%; height: auto;"><strong><?=$against;?></strong></a>
              <?php
            } else {
              if (!empty($play_info['first_user'])) {
                $against = $play_info['first_user'];
              } else {
                $against = 'Add opponent';
              }
              ?>
                <a href="game.php?game=<?=$play_info['game_id'];?>" role="button" class="btn btn-success" style="width: 90%; height: auto;"><strong><?=$against;?></strong></a>
              <?php
            }
              ?>
            </td>
            <td style="text-align: center;">
              <button type="button" class="btn btn-danger" aria-label="Left Align" onclick="end_game('profile.php')">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </button>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    setTimeout(remove_flash, 5000);
  });
</script>
<?php
  include 'include/footer.php';
?>
