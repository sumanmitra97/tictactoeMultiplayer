<?php
  require 'include/init.php';
  require 'include/header.php';

 ?>

<div style="margin-top: -10px;">
  <div style="background-color: #7abde8; width: 100%; height: 450px; position: relative">
    <img src="images/tictactoe.png" alt="Tic Tac Toe" height=317px width=589px id="game_img"/>
  </div>
</div>
<br>
<div class="conatainer text-center">
  <div class="well">
    <a href="signup.php" class="btn btn-success btn-lg" role="button">Signup</a>
    <a href="login.php" class="btn btn-success btn-lg" role="button">Login</a>
  </div>
</div>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-info">
        <div class="panel-heading"><strong>Play with Friends!</strong></div>
        <ul class="list-group">
          <li class="list-group-item">Play from <strong>Any Device</strong> with a browser.</li>
          <li class="list-group-item">Share the <strong>Game ID</strong> with friends and start playing.</li>
        </ul>
      </div>
    </div>
    <div class="col-md-9">
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
      <div class="panel panel-danger">
        <div class="panel-heading"><strong>Win Streak</strong></div>
        <ul class="list-group">
          <li class="list-group-item">Get rewared with bonus points after winning <strong>Five</strong> games in a row.</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-success">
        <div class="panel-heading"><strong>Level up</strong></div>
        <ul class="list-group">
          <li class="list-group-item">Play and Level up.</li>
        </ul>
      </div>
    </div>
    <div class="col-md-9">
    </div>
  </div>
</div>


<?php
  require 'include/footer.php'
?>
