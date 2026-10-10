<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageEnquiry.php');
    if(isset($_POST['feedback']))
    {
        //Form parameters are posted. Lets proceed
        $categoryName = sanitize_input($_POST['categoryName'],'textarea');
        $modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        $customerName = sanitize_input($_POST['customerName'],'textarea');
        $phone = sanitize_input($_POST['phone'],'textarea');
        $testdriveWilling = sanitize_input($_POST['testdrivewilling'],'textarea');
        $testdriveDate = sanitize_input($_POST['testdrivedate'],'textarea');
        $feedback = sanitize_input($_POST['feedback'],'textarea');
        $enc_enquiry_id = sanitize_input($_POST['hdnEnquiryID'],'textarea');
        $enquiry_id = encrypt_decrypt($enc_enquiry_id,'decrypt');
        //print_r($_POST);
        //exit;
        $arrData = array(
            'category_name' => $categoryName,
            'model_name' => $modelName,
            'car_name' => $carName,
            'customer_name' => $customerName,
            'phone' => $phone,
            'testdrive_willing'=> $testdriveWilling,
            'testdrive_date'=> $testdriveDate,
            'feedback'=> $feedback,
            'enquiry_id'=> $enquiry_id
        );
        $updateResult = updateEnquiry($arrData);//insert enquiry data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            //Success
            header('location: enquiry.php?msg=SUCCENQUPD&tab_id=listEnq');
        }
        else{
            //Return back to enquiry page with error message
            header('location: enquiry.php?msg=ERRENQUPD&tab_id=listEnq');
        }
    }
    else{
        //Invalid access of this page. Redirect to enquiry with error code ERR
        header('location: enquiry.php?msg=ERR');
    }
?>
