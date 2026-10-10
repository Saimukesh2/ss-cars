<?php 
    session_start(); 
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCar.php');
    //require_once('data/daManageSession.php');
   //print_r($_POST);
   //exit;

    if(isset($_POST['description']))
    {
        //FOrm parameters are posted. Lets proceed
        $modelDesc = sanitize_input($_POST['description'],'textarea');
       // $categoryID = sanitize_input($_POST['category_id'], 'textarea');
        $modelStatus = sanitize_input($_POST['status'],'textarea'); 
        $enc_model_id = sanitize_input($_POST['hdnModelID'],'textarea');
        $model_id = encrypt_decrypt($enc_model_id,'decrypt');
        $arrData = array(
            //'model_id' => $modelID,
            'model_status' => $modelStatus,
            'model_desc' => $modelDesc,
            'model_id' => $model_id    
        );
        $updateResult = updateModels($arrData);//insert model data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
             //Success
             header('location:models.php?msg=SUCMODUPD&tab_id=listModel');
        }
        else{
            //Return back to models page wtih error message
            header('Location:models.php?msg=ERRMODUPD&tab_id=listModel');
        }
    }
    else{
        //Invalid access of this page. Redirect to models with error code ERR
        header('location:models.php?msg=ERR');
    }




















    
?>