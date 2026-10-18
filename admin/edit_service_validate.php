<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageService.php');
    if(isset($_POST['feedback']))
    {
        $categoryName = sanitize_input($_POST['categoryName'],'textarea');
        $modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        $year = sanitize_input($_POST['year'],'textarea');
        $servicedate = sanitize_input($_POST['servicedate'],'textarea');
        $servicetype = sanitize_input($_POST['servicetype'],'textarea');
        $servicecost = sanitize_input($_POST['servicecost'],'textarea');
        $feedback = sanitize_input($_POST['feedback'],'textarea');
        $enc_service_id = sanitize_input($_POST['hdnServiceID'],'textarea');
        $service_id = encrypt_decrypt($enc_service_id,'decrypt');
        //print_r($_POST);
        //exit;

        $arrData = array(
            'category_name'=> $categoryName,
            'model_name'=> $modelName,
            'car_name'=> $carName,
            'year'=> $year,
            'service_date'=> $servicedate,
            'service_type'=> $servicetype,
            'service_cost'=> $servicecost,
            'feedback'=> $feedback,
            'service_id'=> $service_id
        );

        $updateResult = updateService($arrData);//insert enquiry data into database
        //check if affected rows is greater than 0 to confirm update is successful
        if($updateResult > 0)
        {
            //Success
            header('location: service.php?msg=SUCCSERVUPD&tab_id=listServ');
        }
        else{
            //Error
            header('location: service.php?msg=ERRSERVUPD&tab_id=listServ');
        }
    }
    else{
        //Invalid access of this page.Redirect to service page with error message
        header('location: service.php?msg=ERR');
    }