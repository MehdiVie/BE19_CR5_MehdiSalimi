<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-bottom-dark w-100"  data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="images/Adopt-Paw.png" style="height: 50px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="profile.php">My Profile</a>
          <?php
          
          echo '<a class="nav-link active" aria-current="page" href="home.php">Home</a>';
          
          
          echo '<a class="nav-link active" aria-current="page" href="dashboard.php">DashBoard</a>';
          
          ?>
          <?php
          if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
            echo '<a class="nav-link  active" aria-current="page" href="login.php">Login</a>';
            echo '<a class="nav-link  active" aria-current="page" href="signup.php">SignUp</a>';
          }
          if (isset($_SESSION['user']) || isset($_SESSION['adm'])) {
            echo "<a class='nav-link  active' href='logout.php'>LogOut</a>";
          }
          ?>
        </div>
      </div>
    </div>
</nav>