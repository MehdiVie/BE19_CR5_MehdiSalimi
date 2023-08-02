<?php
    session_start();

    if (!isset($_SESSION['adm'])) {
         header( "Location: login.php" );
    }

    require_once  "public/db_connect.php"; 
    require_once  "public/functions.php"; 

    if (isset($_GET['senior'])) {
        $sql = "SELECT * FROM animal where age >= 8";
    } else {
        $sql = "SELECT * FROM animal";
    }
    

    $result = mysqli_query($connect, $sql);

    $layout="";
    $detail="";
    
    if (mysqli_num_rows($result)) {

        while($row = mysqli_fetch_assoc($result)) {

            $layout .= "
            <div class='card' style='width: 24rem;'>
            
            <img class='card-img-top' src='picture_animal/{$row['picture']}' alt='Card image cap'>
            
            <div class='card-body'>
              
              <h5 class='card-title'>Name: {$row['name']}</h5>
              
              <p class='card-text'>";
              if ($row['status'] == 'Adopted') {

                $sql = "select first_name, last_name, id from user where user.id = (select user_id from pet_adoption where
                 pet_id = ".$row['id'].")";
                 $row2 = retreive_form_database($connect ,$sql);

                 if ($row2) {
                    $layout .= $row['status']. " by: <a href='profile.php?user_id={$row2['id']}'>".$row2['first_name']." ".$row2['last_name']."</a>";
                 }
              }
              
              $layout .= "<br>
              Type: {$row['type']} <br>
              Age: {$row['age']} years old
              </p>
              
              <p class='card-text'>";
              $layout .= substr($row['description'],0,120)."...";
              $layout .= "</p>";
            $layout .="<div class='d-flex justify-content-between'>
            <a href='detail.php?detail={$row['id']}' class='btn btn-primary p-2'>Show Detail</a>
            <a href='update.php?detail={$row['id']}' class='btn btn-warning p-2'>Update Case</a>
            <a href='delete.php?detail={$row['id']}' class='btn btn-danger p-2'>Delete Case</a>
            </div>
              </div>
          </div>";
        }

    } else {
        $layout="No Result!";
    }
?>

<!doctype html>
<html  lang="en">
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Library</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"  crossorigin="anonymous">
       <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
    <div class="container">
        <?php
        include  "public/navbar.php"; 
        ?>
        <div class="d-flex justify-content-around m-4">
            <div>
                <a href='create.php' class='btn btn-success btn-lg'>Create Adoption Case</a>
            </div>
            <div>
                <a href='dashboard.php?senior=yes' class='btn btn-secondary btn-lg'>Show Seniors</a>
            </div>
        </div>
            
        <div class="d-flex justify-content-center">
        
        <div class="wrapper2">
            <?= $layout ?>
        </div>
        </div>
        <div class="detail">
        <?= $detail ?>
        </div>
    </div>
    
        <!--<script src="js/main.js"></script>-->
        <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
<?php
mysqli_close($connect);
?>