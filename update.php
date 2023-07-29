<?php
     session_start();

    if (!isset($_SESSION['adm'])) {
            header( "Location: login.php" );
    }
    require_once  "public/db_connect.php"; 
    require_once  "public/file_Upload.php"; 
    include_once "public/functions.php";

    $id=0;

    if (isset($_GET['detail'])) {

        $id = $_GET['detail'];

    } 

    $name = $name_error = $breed = $breed_error = $age = $age_error = "";
    $type = $type_error = $description = $description_error = $location = $location_error = ""; 

    $sql = "select * from animal where id =". $id;

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
    }


    $layout = "";
    $error = false;
    $flag = true;  
    
    if (isset($_POST['update'])) {

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
        
            $picture_new = fileUpload($_FILES['picture'], 'animal');

            if ($picture_new[1] == "Ok") {
                $picture_upload = $picture_new[0];
            } else {
                $picture_upload = $picture;
            }

            $sql = "UPDATE `animal` SET `name`='$name',`picture`='$picture_upload',`location`='$location',`description`='$description',`size`='$size',`age`='$age',`vaccinated`='$vaccinated',`status`='$status',`type`='$type',`breed`='$breed' WHERE id = ". $id ;

            if (mysqli_query($connect, $sql)) {
                $picture = $picture_new[0];
                $layout = "<div class='alert alert-success' role='alert'>
                New Adoption Case has been created! , {$picture_new[1]}
                </div>";
                header("refresh : 3 , url = detail.php?detail=".$id);

            } else {
                $layout = "<div class='alert alert-danger' role='alert'>
                New Media has NOT been created! , {$picture_new[1]}
                </div>";
                header("refresh : 3 , url = detail.php?detail=".$id);
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
    <div class="grid-container">
    <div>
        <h2 class="text-primary">Create a new Adoption Case</h2>
        
        <form method="POST" enctype= "multipart/form-data">
            <div class="mb-3 mt-3 w-90">
                <label for="name" class= "form-label">Name</label>
                <input  type="text" class="form-control  border-primary" id="name" maxlength="100" aria-describedby="name" name="name"  value="<?= $name ?>" required >
                <span class="text-danger"><?= $name_error ?></span>
            </div>
            <div class="mb-3 w-90">
                <label for="type" class="form-label">Type</label>
                <input type="text"  class="form-control  border-primary" placeholder="exp: dog"  id="type" maxlength="100"  aria-describedby="type"  name="type" value="<?= $type ?>" required>
                <span class="text-danger"><?= $type_error ?></span>
            </div>
            <div class="mb-3 w-90">
                <label for="breed" class="form-label">Breed</label>
                <input type="text"  class="form-control  border-primary"  id="breed" maxlength="100"  aria-describedby="breed"  name="breed" value="<?= $breed ?>" required>
                <span class="text-danger"><?= $breed_error ?></span>
            </div>
            <div class="mb-3 w-90">
                <label for="age" class="form-label">Age</label>
                <input type="number"  class="form-control  border-primary"  id="age" maxlength="2"  aria-describedby="age"  name="age" value="<?= $age ?>" required>
                <span class="text-danger"><?= $age_error ?></span>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="description" class= "form-label">Description</label>
                <textarea class="form-control  border-primary" id="description" aria-describedby="description" name="description"
                 style="height: 150px" placeholder="write description here!" maxlength="1000" required><?php echo $description ?></textarea>
                 <span class="text-danger"><?= $description_error ?></span>
            </div>
            <div class="mb-3 w-90">
                <label for="size" class="form-label">Size</label>
                <select class="form-select  border-primary" id="size" aria-describedby="size" name="size">
                    <option value="Small" <?php if ($size == "Small" ) { echo "selected";}?>>Small</option>
                    <option value="Medium" <?php if ($size == "Medium" ) { echo "selected";}?>>Medium</option>
                    <option value="large" <?php if ($size == "Large" ) { echo "selected";}?>>Large</option>
                </select>
                
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="location" class= "form-label">Location</label>
                <input  type="text" class="form-control  border-primary" id="location" maxlength="200" aria-describedby="location" 
                value="<?= $location ?>" name="location" required>
                <span class="text-danger"><?= $location_error ?></span>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="vaccinated" class= "form-label">Vaccinated?</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vaccinated" id="vaccinated" value="Yes" 
                <?php if ($vaccinated == "Yes" ) { echo "checked";}?> >
                <label class="form-check-label" for="vaccinated">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vaccinated" id="vaccinated" value="No"
                <?php if ($vaccinated == "No" ) { echo "checked";}?>>
                <label class="form-check-label" for="vaccinated">No</label>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="vaccinated" class= "form-label">Status</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Available" 
                <?php if ($status == "Available" ) { echo "checked";}?>>
                <label class="form-check-label" for="status">Available</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status" value="Adopted"
                <?php if ($status == "Adopted" ) { echo "checked";}?> >
                <label class="form-check-label" for="status">Adopted</label>
            </div>
            <div class="mb-3 w-90">
                <label for="picture" class="form-label">picture</label>
                <input type = "file" class="form-control  border-primary" id="picture" aria-describedby="picture"   name="picture">
            </div>
            <button name="update" type="submit" class="btn btn-primary">Update</button>
            <a href="home.php" class="btn btn-warning">Back to home page</a>
        </form>
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