<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-bottom-dark"  data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="web_images/logo_blog.jpg" style="height: 50px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
          <a class="nav-link active" aria-current="page" href="dashboard.php">DashBoard</a>
          <a class="nav-link" href="login.php">Login</a>
          <a class="nav-link" href="signup.php">SignUp</a>
          <?php
          if (isset($_SESSION['user']) || isset($_SESSION['adm'])) {
            echo "<a class='nav-link' href='logout.php'>LogOut</a>";
          }
          ?>
        </div>
      </div>
    </div>
  </nav>