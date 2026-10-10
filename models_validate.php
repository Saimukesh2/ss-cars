<?php 
    session_start(); // Always initialize this in the top
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCar.php');
    //require_once('data/daManageSession.php');
   // print_r($_POST);
    //exit;

    if(isset($_POST['modelName']))
    {
        //FOrm parameters are posted. Lets proceed
        $categoryID = sanitize_input($_POST['category_id'], 'textarea');
        $modelName = sanitize_input($_POST['modelName'], 'textarea');
        $modelDesc = sanitize_input($_POST['description'],'textarea');
        $modelStatus = sanitize_input($_POST['status'],'textarea');
        if($modelName != '')
        {
            //Check if the model name is not already added / exists
            $modelName_upper = strtoupper($modelName);
            //Call a db function to compare model name already exists.
            $model_count = checkModelsExists($modelName_upper);

            if($model_count == 0)
            {
                //Ready to insert into the database
                //storing all form field values into an array
                $arrData = array(
                   'category_id' => $categoryID,
                   'model_name' => $modelName,
                   'model_desc' => $modelDesc,
                   'model_status' => $modelStatus
                );
                $insertResult = insertModels($arrData); //inserted model data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                   //Success
                    header('location:models.php?msg=SUCCMODINS&tab_id=listMod');
                }
                else
                {
                    //Return back to model add page wtih error message
                    header('location:models.php?msg=ERRMODINS&tab_id=addPage');
                }
            }
            else{
                //Model Name already exists. Redirect to model add page with error message
                header('location:models.php?msg=ERRMODDUP&tab_id=addPage');
            }
            
        }
        else
        {
            //Model Name is null. so redirect with warning
            header('location:models.php?msg=ERRMODNAME&tab_id=addPage');
        }
    }
    else
    {
        //Invalid access of this page. Redirect to Model with error code ERR
        header('location:models.php?msg=ERR');
    }
?>