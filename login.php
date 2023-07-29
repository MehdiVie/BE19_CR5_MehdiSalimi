<?php
session_start();

if (isset($_SESSION['user'])) {
    header( "Location: home.php" );
} elseif (isset($_SESSION['adm']) ) {
    header( "Location: dashboard.php" );
}

include_once "public/db_connect.php";
include_once "public/functions.php";

$email= $email_error = $password_error = $layout ="";
$error = false;




if(isset($_POST['login'])) {
    $email = clean_inputs($_POST['email']);
    $password = clean_inputs($_POST['password']);

    if (!filter_var($email , FILTER_VALIDATE_EMAIL)) {

        $error = True;
        $email_error = "Email is not valid!";

    } else {
        $sql = "select * from user where email = '$email'  ";
        if (!check_form_database($connect,$sql)) {
            $error = True;
            $email_error ="This Email is not registered!";
        }
    }

    if (empty($password)) {
        $error = True;
        $password_error = "Password should not be empty!";
    } else if (strlen($password) < 6) {
        $error = True;
        $password_error = "Password must have at least 6 characters!";
    }

    if (!$error) {
        $password = hash( "sha256", $password);
        $sql = "select * from user where email = '$email' and password = '$password' ";
        $row = retreive_form_database($connect,$sql);
   
    
        if ($row) {

            if ($row['status'] == 'user') {

                $_SESSION['user'] = $row['id'];
                header('Location: home.php');

            } else if ($row['status'] == 'adm') {

                $_SESSION['adm'] = $row['id'];
                header('Location: dashboard.php');

            }   
    
        } else {
            $layout .= "<div class='alert alert-danger'>
            <p>Password is not correct!Try again..</p>
          </div>";

        }
    }


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Login</title>
</head>
<body>
    <?php
    include_once "public/navbar.php";
    ?>

    <div class="container">
        <div>
            <?= $layout ?>
        </div>
        <h1 class="text-center">Login page </h1>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Email address </label>
                <input type="email" class="form-control bordered border-primary w-50" id="email" name="email" placeholder="Email address" 
                value="<?= $email ?>" autocomplete="off">
                <span class="text-danger"><?= $email_error ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control bordered border-primary w-50" id="password" name="password" autocomplete="off">
                <span class="text-danger"><?= $password_error ?></span>
            </div>
            <button name="login" type="submit" class="btn btn-primary" >Login</button>
            <span>you don't have an account? <a href="register.php">register here </a></span>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connect);
?>