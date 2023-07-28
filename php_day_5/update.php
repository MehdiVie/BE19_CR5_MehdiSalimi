<?php
session_start();
$id=0;
if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
    header( "Location: login.php" );
} else if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
} else {
    $id = $_SESSION['adm'];
}

include_once "db_connect.php";
include_once "file_upload.php";
include_once "functions.php";

$email= $email_error = $password_error = $layout ="";
$fname = $fname_error = $lname = $lname_error = $data_of_birth = $date_error ="";

$error = false;

$sql = "select * from users where id = ".$id;
$row = retreive_form_database($connect,$sql);

$fname = $row['first_name'];
$lname = $row['last_name'];
$email = $row['email'];
$date_of_birth=$row['date_of_birth'];
$picture=$row['picture'];


if(isset($_POST['update'])) {

    foreach($_POST as $key => $value) {
        $$key = $value;
        echo $$key."<br>";
      }

    $fname = clean_inputs($_POST["fname"]);
    $lname = clean_inputs($_POST[ "lname"]);
    $email = clean_inputs($_POST["email"]);
    $date_of_birth = clean_inputs($_POST["date_of_birth"]);
    

    $fname_error = check_name('first name' , $fname);
    $lname_error = check_name('last name' , $lname);
    if (!empty($fname_error) || !empty($lname_error)) {
        $error = True;
    }

    if (!filter_var($email , FILTER_VALIDATE_EMAIL)) {
        $error = True;
        $email_error = "Email is not valid!";

    } else {
        $sql = "select * from users where email = '$email' ";
        
        if ( (check_form_database($connect,$sql)) && ($row['email']!=$email) ) {
            $error = True;
            $email_error ="This Email is already registered!";
        }
    }

    if ( empty ($date_of_birth)){
        $error = true ;
        $date_error = "date of birth can't be empty!" ;
    }

    if ($error==false) {

        $picture = fileUpload($_FILES[ "picture"]);

        if($row["picture"] != "avatar.png"){
            unlink("pictures/$row[picture]" );
        }

        $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', picture = '$picture[0]', date_of_birth = '$date_of_birth', email = '$email' WHERE id = {$id}" ;
        
        $result = mysqli_query($connect, $sql);

        if ($result){
            $picture = $picture[0];
            $layout.="<div class='alert alert-success'>
               <p>Your Account has been updated!</p>
           </div>" ;


        } else  {
            $layout.="<div class='alert alert-danger'>
               <p>Something went wrong, please try again later!</p>
           </div>" ;
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
    <link rel="stylesheet" href="CSS/main.css">
    <title>UpDate</title>
</head>
<body>
    <?php
    include_once "navbar.php";
    ?>

    <div class="container">
    
        <div>
            <?= $layout ?>
        </div>
        <h1 class="text-center">UpDate</h1>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="grid-container">
        <div>
            <div class="mb-3">
                <label for="picture" class="form-label">Profile picture </label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3 mt-3" >
                <label for="fname" class="form-label">First name </label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $fname ?>" >
                <span class="text-danger"><?= $fname_error ?></span>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name </label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?= $lname ?>" >
                <span class="text-danger"><?= $lname_error ?></span>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date of birth</label>
                <input type="date" class= "form-control" id="date"  name="date_of_birth" value="<?= $date_of_birth ?>" >
                <span class="text-danger"><?= $date_error ?></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>" >
                <span class="text-danger"><?= $email_error ?></span>
            </div>
            <button name="update" type="submit" class="btn btn-primary" >UpDate</button>
        </div>
        <div>
            <div class="mb-3 d-flex justify-content-center">
                <img src="pictures/<?= $picture ?>" class="home_pic" >
            </div>
        </div>
        </div>
        </form>
    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>