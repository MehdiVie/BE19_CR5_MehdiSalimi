<?php
     session_start();

    if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
            header( "Location: login.php" );
    } else if (isset($_SESSION['user'])) {
        $user_id = isset($_SESSION['user']);
    } elseif (isset($_SESSION['adm']) ) {
        $user_id = isset($_SESSION['adm']);
    }
    

    require_once "public/db_connect.php"; 
    require_once "public/file_Upload.php"; 
    include_once "public/functions.php";

    $pet_id = 0;
    $adoption = False;
    $adoption_confirm = False;
    $layout = "";

    if (isset($_GET['detail'])) {

        $pet_id = $_GET['detail'];

    } 
    
    if (isset($_GET['adoption'])) {

        if ($_GET['adoption'] == "yes") {

            $adoption = True;
        }

    } else if (isset($_GET['pet_id'])) {

        $pet_id = intval($_GET['pet_id']);

    }

    if (isset($_GET['pet_id']))  {

        $sql = "INSERT INTO `pet_adoption`(`user_id`, `pet_id`, `adoption_date`) VALUES ($user_id,$pet_id,NOW())";

        if (mysqli_query($connect, $sql)) {

            $sql ="UPDATE `animal` SET `status`='Adopted' WHERE id =".$pet_id;

            if (mysqli_query($connect, $sql)) {

                $layout .= "<div class='alert alert-success' role='alert'>
                Hooora! You adopted a PeTT!!!!! :)
                </div>";
                header("refresh : 3 , url = home.php");

            } else {

            $layout .= "<div class='alert alert-danger' role='alert'>
            Try Again Later....:(! ,
            </div>";
            header("refresh : 3 , url = home.php");
            }
            
        } else {

            $layout .= "<div class='alert alert-danger' role='alert'>
            Try Again Later....:(!
            </div>";
            header("refresh : 3 , url = home.php");
        }
    
    }

    $name = $name_error = $breed = $breed_error = $age = $age_error ="";
    $type = $type_error = $description = $description_error = $location = $location_error = ""; 

    $sql = "select * from animal where id =". $pet_id;


    $row = retreive_form_database($connect ,$sql);

    if ($row) {
        $name = $row['name'];
        $breed = $row['breed'];
        $age = $row['age'];
        $type = $row['type'];
        $size = $row['size'];
        $description = $row['description'];
        $location = $row['location'];
        $vaccinated = $row['vaccinated'];
        $status = $row['status'];
        $picture = $row['picture'];
        $pet_id =$row['id'];
    }


    
    $error = false;
    $flag = true;  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Create new Media</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"  crossorigin="anonymous">
</head>
<body>
    <?php
        include  "public/navbar.php"; 
    ?>
    <?= $layout ?>
    <div class="container mt-5">
    <div class="grid-container border border-black p-3">
    <div>
        <h2 class="text-primary">Detail</h2>
        
            <div class="mb-3 mt-3 w-90">
                <label for="name" class= "form-label">Name: </label><br><?=$name ?>
            </div>
            <div class="mb-3 w-90">
                <label for="type" class="form-label">Type: </label><br><?=$type ?>
            </div>
            <div class="mb-3 w-90">
                <label for="breed" class="form-label">Breed: </label><br><?=$breed ?>
            </div>
            <div class="mb-3 w-90">
                <label for="age" class="form-label">Age:</label><br><?=$age ?>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="description" class= "form-label">Description:</label><br><?=$description ?>
            </div>
            <div class="mb-3 w-90">
                <label for="size" class="form-label">Size:</label><br><?=$size ?>        
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="location" class= "form-label">Location:</label><br><?=$location ?>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="vaccinated" class= "form-label">Vaccinated:</label><br><?=$vaccinated ?>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="vaccinated" class= "form-label">Status:</label><br><?=$status ?>
            </div>
            <a href="home.php" class="btn btn-warning">Back to home page</a>
            <?php if ($adoption) { ?>
                <a href="detail.php?pet_id=<?=$pet_id?>" class="btn btn-success">Take Me Home!</a>
            <?php } ?>
    </div>
    <div>
        <div class="mb-3 d-flex justify-content-center ">
            <img src="picture_animal/<?= $picture ?>" class="home_pic" >
        </div>
    </div>
    </div>
    </div>
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connect);
?>