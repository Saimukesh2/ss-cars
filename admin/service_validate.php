<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageService.php');
    if(isset($_POST['servicetype']))
    {
        //$categoryName = sanitize_input($_POST['categoryName'],'textarea');
        //$modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        $year = sanitize_input($_POST['year'],'textarea');
        $employeeName = sanitize_input($_POST['employeeName'],'textarea');
        $customerName = sanitize_input($_POST['customerName'],'textarea');
        $servicedate = sanitize_input($_POST['servicedate'],'textarea');
        $servicecost = sanitize_input($_POST['servicecost'],'textarea');
        $servicetype = sanitize_input($_POST['servicetype'],'textarea');
        $feedback = sanitize_input($_POST['feedback'],'textarea');
        //print_r($_POST);
        //exit;

        $arrData = array(
            //'category_name'=> $categoryName,
            //'model_name'=> $modelName,
            'car_name'=> $carName,
            'year'=> $year,
            'employee_name'=> $employeeName,
            'customer_name'=> $customerName,
            'service_date'=> $servicedate,
            'service_cost'=> $servicecost,
            'service_type'=> $servicetype,
            'feedback'=> $feedback
        );
        $insertResult = insertService($arrData);//insert enquiry data into database
        //check if affected rows is equal to 1 to confirm insert is successful  
        if($insertResult == 1)
        {
            //Success
            header('location: service.php?msg=SUCCSERVINS&tab_id=listServ');
        }
        else{
            //Error
            header('location: service.php?msg=ERRSERVINS&tab_id=addServ');
        }
    }
    else{
        //Invalid access of this page.Redirect to service page with error message
        header('location: service.php?msg=ERR');
    }
?>