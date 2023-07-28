<?php
session_start();

if (!isset($_SESSION['user'])) {
    header( "Location: login.php" );
}

include_once "db_connect.php";
include_once "functions.php";

$sql = "select * from users where id = ".$_SESSION['user'];
$row = retreive_form_database($connect,$sql);

$layout="";

$fname = $row['first_name'];
$lname = $row['last_name'];
$email = $row['email'];
$date_of_birth=$row['date_of_birth'];
$picture = $row['picture'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/main.css">
    <title>Home</title>
</head>
<body>
    <?php
    include_once "navbar.php";
    ?>
    <div class="container">
        <div>
            <?= $layout ?>
        </div>
        <h1 class="text-center">Home</h1>
        <div>
        <div class="grid-container">
            <div>
                <div class="mb-3">
                    <label for="email" class="form-label">First name :</label><?= $fname ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Last name :</label><?= $lname ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Birth Date :</label><?= $date_of_birth ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address :</label><?= $email ?>
                </div>
                <a class="btn btn-primary" href="update.php">Go to UPDATE Page</a>
            </div>
            <div>
                <div class="mb-3 d-flex justify-content-center">
                    <img src="pictures/<?= $picture ?>" class="home_pic" >
                </div> 
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>