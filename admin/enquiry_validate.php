<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageEnquiry.php');
    //require_once('data/daManageCustomer.php');

    if(isset($_POST['customerName']))
    {
        //Form parameters are posted. Lets proceed
        //$categoryName = sanitize_input($_POST['categoryName'], 'textarea');
        //$modelName = sanitize_input($_POST['modelName'], 'textarea');
        
        //exit;
        
        $carName = sanitize_input($_POST['carName'], 'textarea');
        $employeeName = sanitize_input($_POST['employeeName'], 'textarea');
        $customerName = sanitize_input($_POST['customerName'], 'textarea');
        $phone = sanitize_input($_POST['phone'], 'textarea');
        $testdriveWilling = sanitize_input($_POST['testdrivewilling'], 'textarea');
        $testdriveDate = sanitize_input($_POST['testdrivedate'], 'textarea');
        $feedback = sanitize_input($_POST['feedback'], 'textarea');
        
                $arrData = array(
                    //'category_name'=> $categoryName,
                    //'model_name'=> $modelName,
                    'car_name'=> $carName,
                    'employee_name'=> $employeeName,
                    'customer_name'=> $customerName,
                    'phone'=> $phone,
                    'testdrive_willing'=> $testdriveWilling,
                    'testdrive_date'=> $testdriveDate,
                    'feedback'=> $feedback

                );
                //print_r($arrData);
                //exit;
                $insertResult = insertEnquiry($arrData);//insert model data into database
                //check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                    //Success
                    header('location: enquiry.php?msg=SUCCENQINS&tab_id=listEnq');
                }
                else{
                    //Error
                    header('location: enquiry.php?msg=ERRENQINS&tab_id=addEnq');
                }
            
    }
    else{
        //Invalid access of this page. Redirect to employee with error code ERR
        header('location: enquiry.php?msg=ERR');
    }