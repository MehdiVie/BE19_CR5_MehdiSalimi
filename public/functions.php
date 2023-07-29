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

function check_phone_number($parameter, $item) {
    $error_msg="";
    
    if(empty($item)){
        $error_msg = "Please, enter $parameter";
    } elseif(strlen($item) < 7){
        $error_msg = "$parameter must have at least 7 characters." ;
    } elseif (!preg_match("/^[0-9-\+\s]+$/D" , $item)) {
        $error_msg = "$parameter must not contain letters." ;
    }

    return $error_msg;

}

function check_age_animal($parameter, $item) {
    $error_msg="";
    
    if(empty($item)){
        $error_msg = "Please, enter $parameter";
    } elseif(($item) > 25){
        $error_msg = "$parameter must valid." ;
    } elseif (!preg_match("/^[0-9]+$/D" , $item)) {
        $error_msg = "$parameter must only contain digits." ;
    }

    return $error_msg;

}

function check_address($parameter, $item) {
    $error_msg="";
    
    if(empty($item)){
        $error_msg = "Please, enter $parameter";
    } elseif(strlen($item) < 10){
        $error_msg = "$parameter must have at least 10 characters." ;
    } elseif (!preg_match("/^[\w\-,\+\s]+$/D" , $item)) {
        $error_msg = "$parameter must contain only letters, numbers and spaces." ;
    }

    return $error_msg;

}

?>