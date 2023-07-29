<?php
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
    header( "Location: login.php" );
} else if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
} else {
    $id = $_SESSION['adm'];
}

if (isset($_GET['user_id'])) {
    $id = intval($_GET['user_id']);
}

include_once "public/db_connect.php";
include_once "public/functions.php";

$sql = "select * from user where id = ".$id;
$row = retreive_form_database($connect,$sql);

$layout="";

$fname = $row['first_name'];
$lname = $row['last_name'];
$email = $row['email'];
$address=$row['address'];
$phone_number=$row['phone_number'];
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
    <div class="container">
    <div>
    <?php
    include_once "public/navbar.php";
    ?>
    </div>
        <div>
            <?= $layout ?>
        </div>
        <h1 class="text-center">Home</h1>
        <div>
        <div class="grid-container border border-black p-3">
            <div >
                <?php
                if (!isset($_GET['user_id'])) {
                ?>
                <div class="mb-3">
                    <label  class="form-label">User Type :</label><?=(isset($_SESSION['user']))? "USER" :  "ADMIN" ; ?>
                </div>
                <?php
                }
                ?>
                <div class="mb-3">
                    <label  class="form-label">First name :</label><?= $fname ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last name :</label><?= $lname ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address :</label><?= $address ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number:</label><?= $phone_number ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email :</label><?= $email ?>
                </div>
                
            </div>
            <div>
                <div class="mb-3 d-flex justify-content-end ">
                    <img src="picture_user/<?= $picture ?>" class="home_pic_profile" >
                </div> 
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connect);
?>