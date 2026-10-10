<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageCar.php');
    $result = array();
    if(isset($_POST))
    {
        $enc_car_id = $_POST['enc_carID'];
        $car_id = encrypt_decrypt($enc_car_id,'decrypt');
        //call db function to delete this category
        $affectedRows = deleteCar($car_id);
        if($affectedRows == 1)
        {
            $result['msg'] = "Success";
            $result['msg_detail'] = "Car Deleted Successfully";
        }
        else{
            $result['msg'] = "Failed";
            $result['msg_detail'] = "Car is Failed to Delete";
        }
    }
    else{
        $result['msg'] = "Failed";
        $result['msg_detail'] = "unexpected error";
    }
    echo json_encode($result);
?>