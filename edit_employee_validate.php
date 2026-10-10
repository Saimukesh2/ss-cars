<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageEmployee.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['address']))
    {
        //Form parameters are posted. Lets proceed
        $address = sanitize_input($_POST['address'],'textarea');
        $phone = sanitize_input($_POST['phone'],'textarea');
        $mailid = sanitize_input($_POST['mailid'],'textarea');
        $position = sanitize_input($_POST['position'],'textarea');
        $hiredate = sanitize_input($_POST['hiredate'],'textarea');
        $gender = sanitize_input($_POST['gender'],'textarea');
        $age = sanitize_input($_POST['age'], 'textarea');
        $dateofbirth = sanitize_input($_POST['dateofbirth'], 'textarea');
        $username = sanitize_input($_POST['username'], 'textarea');
        $password = sanitize_input($_POST['password'], 'textarea');
        //print_r($_POST);    
        //exit;
        $enc_employee_id = sanitize_input($_POST['hdnEmployeeID'],'textarea');
        $employee_id = encrypt_decrypt($enc_employee_id,'decrypt');
        //exit;
        $arrData = array(
            'address'=> $address,
            'phone'=> $phone,
            'mail_id'=>$mailid,
            'position'=> $position,
            'hire_date'=> $hiredate,
            'gender'=> $gender,
            'age'=> $age,
            'dob'=> $dateofbirth,
            'user_name'=> $username,
            'password'=> $password,
            'employee_id'=> $employee_id
        );
        $updateResult = updateEmployee($arrData);//insert employee data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            //Success
            header('location: employee.php?msg=SUCCEMPUPD&tab_id=listEmp');
        } 
        else{
            //Return back to employee page
            header('Location: employee.php?msg=ERREMPUPD&tab_id=listEmp');
            }    
    }
    else{
        //Invalid access of this page. Redirect to employee page with error code ERR
        header('location: employee.php?msg=ERR');
    }