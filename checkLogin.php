<?php
    session_start();
    include_once("common/config.php");
    include_once("common/dbconn.php");
    require_once('common/common_functions.php');
    require_once('data/daManageSession.php');
    require_once('data/daManageLogin.php');
    

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        //Check if anything is posted
        $user_name  = sanitize_input($_POST['txtUserID'],'text' );
        $password = sanitize_input($_POST['txtPassword'],'text');

        $arrData = array();
        $arrData['user_name'] = $user_name;
        $arrData['password'] = $password;
        //print_r($arrData);
        $count = checkLogin($arrData);
        
        if($count == 1)
        {
            //Login is successful
            header('location:dashboard.php');    
        }
        else
        {
            //Login failed. Redirect to login page
            header('location:index.php?msg=ERR01');    
        }

        
    }
    else
    {
        header('location:index.php?msg=ERR');
    }
?>