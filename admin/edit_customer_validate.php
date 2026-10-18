<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCustomer.php');
    if(isset($_POST['address']))
    {
        //Form parameters are posted. Lets proceed
        $address = sanitize_input($_POST['address'],'textarea');
        $phone = sanitize_input($_POST['phone'],'textarea');
        $mailid = sanitize_input($_POST['mailid'],'textarea');
        $gender = sanitize_input($_POST['gender'],'textarea');
        $age = sanitize_input($_POST['age'],'textarea');
        $dateofbirth = sanitize_input($_POST['dateofbirth'],'textarea');
        $city = sanitize_input($_POST['city'],'textarea');
        $state = sanitize_input($_POST['state'],'textarea');
        $enc_customer_id = sanitize_input($_POST['hdnCustomerID'],'textarea');
        $customer_id = encrypt_decrypt($enc_customer_id,'decrypt');
        //print_r($_POST);

       // exit;
        $arrData = array(
            'address'=>$address,    
            'phone'=>$phone,
            'mail_id'=>$mailid,
            'gender'=>$gender,
            'age'=>$age,
            'dob'=>$dateofbirth,
            'city'=>$city,
            'state'=>$state,
            'customer_id'=>$customer_id
        );
        $updateResult = updateCustomer($arrData);//insert customer data into database
        //Check if affected rows is greater than 0 to confirm update is successful
        //echo $updateResult;
        if($updateResult > 0)
        {
            //Success
            header('location: customer.php?msg=SUCCCUSTUPD&tab_id=listCust');
        }
        else{
            //return back to customer page with error message
            header('location: customer.php?msg=ERRCUSTUPD&tab_id=listCust');
        }
    }
    else{
        //Invalid access of this page. Redirect to models with error code ERR
        header('location: customer.php?msg=ERR');
    }