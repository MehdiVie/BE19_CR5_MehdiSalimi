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
$row2 = retreive_form_database($connect,$sql);

$layout="";

$fname = $row2['first_name'];
$lname = $row2['last_name'];
$email = $row2['email'];
$address=$row2['address'];
$phone_number=$row2['phone_number'];
$picture = $row2['picture'];

$sql = "select * from animal where id in (select pet_id from pet_adoption where user_id = $id )";
$result = mysqli_query($connect,$sql);



if (mysqli_num_rows($result)) {

    while($row = mysqli_fetch_assoc($result)) {

        $layout .= "
        <div class='card' style='width: 24rem;'>
        
        <img class='card-img-top' src='picture_animal/{$row['picture']}' alt='Card image cap'>
        
        <div class='card-body'>
          
          <h5 class='card-title'>Name: {$row['name']}</h5>
          
          <p class='card-text'>
          {$row['status']} <br>
          Type: {$row['type']} <br>
          Age: {$row['age']} years old
          </p>
          
          <p class='card-text'>";
          $layout .= substr($row['description'],0,120)."...";
          $layout .= "</p>";
        $layout .="<div class='d-flex justify-content-between'>
        <a href='detail.php?detail={$row['id']}' class='btn btn-primary p-2'>Show Detail</a>";
        if ($row['status'] == 'Available') {
            $layout.="<a href='detail.php?detail={$row['id']}&adoption=yes' class='btn btn-success p-2'>Take Me Home!</a>";
        }
        $layout.="</div>
          </div>
      </div>";
    }

} else {
    $layout.="You have adopted no Pet yet!";
}

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
                <div>
                    <h2 class="text-center text-success">Pet(s) Adopted by <?php echo $fname." ".$lname; ?>!</h2>
                </div>
                <div class="wrapper2">
                    <?= $layout ?>
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