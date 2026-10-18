<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageEmployee.php');
    $result = array();
    if(isset($_POST))
    {
        $enc_employee_id = $_POST['enc_employeeID'];
        $employee_id = encrypt_decrypt($enc_employee_id,'decrypt');
        //call db function to delete this employee
        $affectedRows = deleteEmployee($employee_id);
        if($affectedRows == 1)
        {
            $result['msg'] = "Success";
            $result['msg_detail'] = "Employee Deleted Successfully";
        }
        else{
            $result['msg'] = "Failed";
            $result['msg_detail'] = "Employee Failed To Be Deleted";
        }
    }
    else{
        $result['msg'] = "Failed";
        $result['msg_detail'] = "unexpected error.";
    }
    echo json_encode($result);