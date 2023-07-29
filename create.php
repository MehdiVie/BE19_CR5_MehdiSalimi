<?php
     session_start();

    if (!isset($_SESSION['adm'])) {
            header( "Location: login.php" );
    }
    require_once  "public/db_connect.php"; 
    require_once  "public/file_Upload.php"; 
    include_once "public/functions.php";

    $name = $name_error = $breed = $breed_error = $age = $age_error = "";
    $type = $type_error = $description = $description_error = $location = $location_error = ""; 

    $layout = "";
    $error = false;
    $flag = true;  
    


    if (isset($_POST['create'])) {

        $name = clean_inputs($_POST["name"]);
        $breed = clean_inputs($_POST[ "breed"]);
        $age = clean_inputs($_POST["age"]);
        $type = clean_inputs($_POST[ "type"]);
        $description = clean_inputs($_POST["description"]);
        $location = clean_inputs($_POST["location"]);
        $status = $_POST['status'];
        $size = $_POST['size'];
        $vaccinated = $_POST['vaccinated'];
        

        $name_error = check_name('name' , $name);
        $breed_error = check_name('breed' , $breed);
        $type_error = check_name('type' , $type);
        if (!empty($name_error) || !empty($type_error) || !empty($breed_error)) {
            $error = True;
        }

        $age_error = check_age_animal('Age' , $age);
        if (!empty($age_error)) {
            $error = True;
        }

        $location_error = check_address('address' , $location);
        if (!empty($location_error)) {
            $error = True;
        }

        if (strlen($description) < 5) {
            $error = True;
            $description_error = "Description must have at least 5 charachters!";
        }
        
        if (!$error) {
        
            $picture = fileUpload($_FILES['picture'], 'animal');

            $sql = "INSERT INTO `animal` (`name`, `type`, `breed`, `description`, `size`, `age`, `vaccinated`, `status`, `location`, `picture`) VALUES ('$name','$type','$breed','$description','$size',$age,'$vaccinated','$status','$location','$picture[0]')" ;

            if (mysqli_query($connect, $sql)) {

                $layout = "<div class='alert alert-success' role='alert'>
                New Media has been created! , {$picture[1]}
                </div>";
                header("refresh : 3 , url = home.php");

            } else {
                $layout = "<div class='alert alert-danger' role='alert'>
                New Media has NOT been created! , {$picture[1]}
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
        <h2 class="text-primary">Create a new Adoption Case</h2>
        <form method="POST" enctype= "multipart/form-data">
            <div class="mb-3 mt-3 w-50">
                <label for="name" class= "form-label">Name</label>
                <input  type="text" class="form-control  border-primary" id="name" maxlength="100" aria-describedby="name" name="name"  value="<?= $name ?>" required >
                <span class="text-danger"><?= $name_error ?></span>
            </div>
            <div class="mb-3 w-50">
                <label for="type" class="form-label">Type</label>
                <input type="text"  class="form-control  border-primary" placeholder="i.e: dog"  id="type" maxlength="100"  aria-describedby="type"  name="type" value="<?= $type ?>" required>
                <span class="text-danger"><?= $type_error ?></span>
            </div>
            <div class="mb-3 w-50">
                <label for="breed" class="form-label">Breed</label>
                <input type="text"  class="form-control  border-primary"  id="breed" maxlength="100"  aria-describedby="breed"  name="breed" value="<?= $breed ?>" required>
                <span class="text-danger"><?= $breed_error ?></span>
            </div>
            <div class="mb-3 w-50">
                <label for="age" class="form-label">age</label>
                <input type="number"  class="form-control  border-primary"  id="age" maxlength="2"  aria-describedby="age"  name="age" value="<?= $age ?>" required>
                <span class="text-danger"><?= $age_error ?></span>
            </div>
            <div class="mb-3 mt-3 w-50">
                <label for="description" class= "form-label">Description</label>
                <textarea class="form-control  border-primary" id="description" aria-describedby="description" name="description"
                 style="height: 150px" placeholder="write description here!" maxlength="1000" required><?php echo $description ?></textarea>
                 <span class="text-danger"><?= $description_error ?></span>
            </div>
            <div class="mb-3 w-50">
                <label for="size" class="form-label">Size</label>
                <select class="form-select  border-primary" id="size" aria-describedby="size" name="size">
                    <option value="Small" selected>Small</option>
                    <option value="Medium">Medium</option>
                    <option value="large">Large</option>
                </select>
                
            </div>
            <div class="mb-3 mt-3 w-50">
                <label for="location" class= "form-label">Location</label>
                <input  type="text" class="form-control  border-primary" id="location" maxlength="200" aria-describedby="location" 
                value="<?= $location ?>" name="location" required>
                <span class="text-danger"><?= $location_error ?></span>
            </div>
            <div class="mb-3 mt-3 w-50">
                <label for="vaccinated" class= "form-label">Vaccinated?</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vaccinated" id="vaccinated" value="Yes" checked>
                <label class="form-check-label" for="vaccinated">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vaccinated" id="vaccinated" value="No">
                <label class="form-check-label" for="vaccinated">No</label>
            </div>
            <div class="mb-3 mt-3 w-50">
                <label for="vaccinated" class= "form-label">Status</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Available" checked>
                <label class="form-check-label" for="status">Available</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Adopted">
                <label class="form-check-label" for="status">Adopted</label>
            </div>
            <div class="mb-3 w-50">
                <label for="picture" class="form-label">picture</label>
                <input type = "file" class="form-control  border-primary" id="picture" aria-describedby="picture"   name="picture">
            </div>
            <button name="create" type="submit" class="btn btn-primary">Create</button>
            <a href="home.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connect);
?>