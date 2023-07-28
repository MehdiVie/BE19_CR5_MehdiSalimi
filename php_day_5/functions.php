<?php



function clean_inputs($data) {

    $data = trim($data);

    $data = strip_tags($data);

    $data = htmlspecialchars($data);

    return $data;
}

function check_form_database($connect ,$sql) {
    
    $result = mysqli_query($connect , $sql);
    
    if (mysqli_num_rows($result) > 0) {

        return True;

    }

    return false;
}

function retreive_form_database($connect ,$sql) {

    $result = mysqli_query($connect , $sql);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {

        return $row;

    }


    return false;
}

function check_name($parameter, $item) {
    $error_msg="";

    if(empty($item)){
        $error_msg = "Please, enter $parameter";
    } elseif(strlen($item) < 3){
        $error_msg = "$parameter must have at least 3 characters." ;
    } elseif (!preg_match("/^[a-zA-Z\s]+$/" , $item)) {
        $error_msg = "$parameter must contain only letters and spaces." ;
    }

    return $error_msg;
}

?>