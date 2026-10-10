<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageEmployee.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['employeeName']))
    {
        $employeeName = sanitize_input($_POST['employeeName'],'textarea');
        $mailid = sanitize_input($_POST['mailid'],'textarea');
        $address = sanitize_input($_POST['address'],'textarea');
        $phone = sanitize_input($_POST['phone'],'textarea');
        $position = sanitize_input($_POST['position'],'textarea');
        $hiredate = sanitize_input($_POST['hiredate'],'textarea');
        $gender = sanitize_input($_POST['gender'],'textarea');
        $age = sanitize_input($_POST['age'], 'textarea');
        $dateofbirth = sanitize_input($_POST['dateofbirth'], 'textarea');
        $username = sanitize_input($_POST['username'], 'textarea');
        $password = sanitize_input($_POST['password'], 'textarea');
        if($employeeName != '')
        {
            //check if employee name already exists
            $employeeName_upper = strtoupper($employeeName);
            //call a db function to check if employee name already exits
            $employee_count = checkEmployeeExists($employeeName_upper);
            if($employee_count == 0)
            {
                //ready to insert a record
                //storing all the form field in an array
                $arrData = array(
                    'employee_name'=> $employeeName,
                    'mail_id'=> $mailid,
                    'address'=> $address,
                    'phone'=> $phone,
                    'position'=> $position,
                    'hire_date'=> $hiredate,
                    'gender'=> $gender,
                    'age'=> $age,
                    'dob'=> $dateofbirth,
                    'user_name'=> $username,
                    'password'=> $password
                );
                $insertResult = insertEmployee($arrData);//insert model data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                    //Success
                    header('Location: employee.php?msg=SUCCEMPINS&tab_id=listEmp');
                }
                else{
                    //Return back to employee page with error message
                    header('location: employee.php?msg=ERREMPINS&tab_id=addEmp');
                }
            }
            else{
                //employee name already exists
                header('location: employee.php?msg=ERREMPNAME&tab_id=addEmp');
            }
        }
    }
    else{
        //Invalid access of this page. Redirect to employee with error code ERR
        header('location: employee.php?msg=ERR');
    }