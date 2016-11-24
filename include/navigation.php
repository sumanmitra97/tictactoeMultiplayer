<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#toggle-menu" aria-expand="false">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php" class="navbar-brand">TicTacToe</a>
    </div>
    <div class="collapse navbar-collapse" id="toggle-menu">
      <ul class="nav navbar-nav">
        <li><a href="game.php">Game</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(is_logged_in()) : ?>
          <li class="dropdown" role="menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expan="false">Hello <strong><?= $_SESSION['userid'] ?></strong> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="profile.php">Profile</a></li>
              <li><a href="edit_profile.php">Edit Profile</a></li>
              <li><a href="change_password.php">Change Password</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expand="false"><strong>Profile</strong> <span class=caret></span></a>
            <ul class="dropdown-menu">
              <li><a href="login.php">Login</a></li>
              <li><a href="signup.php">Signup</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="" style="padding:30px;">
</div>
