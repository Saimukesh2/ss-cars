<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCar.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['features']))
    {
        //Form parameters are posted. Lets proceed
        $features = sanitize_input($_POST['features'],'textarea');
        //$model_id = sanitize_input($_POST['model_id'], 'textarea');
        $year = sanitize_input($_POST['year'], 'textarea');
        $arrColors = $_POST['colorAvailable'];
        $price = sanitize_input($_POST['price'], 'textarea');
        $mieleage = sanitize_input($_POST['mieleage'], 'textarea');
        $status = sanitize_input($_POST['status'], 'textarea');
        $enc_car_id = sanitize_input($_POST['hdnCarID'],'textarea');
        $car_id = encrypt_decrypt($enc_car_id,'decrypt');
        //print_r($_POST);
        //exit;
       
        $arrData = array(
            'features'=> $features,
            //'car_id'=> $carID,
            'year'=> $year,
            'color_available'=> $arrColors,
            'price'=> $price,
            'mieleage'=> $mieleage,
            'status'=> $status,
            'car_id'=> $car_id
        );
        $updateResult = updateCar($arrData);//insert model data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            //Success
            header('location: cars.php?msg=SUCCCARUPD&tab_id=listcars');
        }
        else{
            //Return back to cars page with error message
            header('location: cars.php?msg=ERRCARUPD&tab_id=listcars');
        }
    }
    else{
        //Invalid access of this page. Redirect to cars with error code ERR
        header('location: cars.php?msg=ERR');
    }