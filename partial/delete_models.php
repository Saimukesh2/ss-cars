<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageCar.php');
    $result = array();
    if(isset($_POST))
    {
        $enc_model_id = $_POST['enc_modelID'];
        $model_id = encrypt_decrypt($enc_model_id,'decrypt');
        //call db function to delete this category
        $count = checkModelsExistsinCars($model_id);
        
        if($count == 0)
        {
            //Count is zero, so we can delete the model
            $affectedRows = deleteModel($model_id);
            if($affectedRows == 1)
            {
                $result['msg'] = "Success";
                $result['msg_detail'] = "Model Deleted Successfully";
            }
            else{
                $result['msg'] = "Failed";
                $result['msg_detail'] = "Model is Failed to Delete";
            }
        }
        else
        {
            //This model cannto be deleted as it is having a child
            $result['msg'] = "Failed";
            $result['msg_detail'] = "Model is Failed to Delete as it is having a Existing Car";

        }
        
    }
    else{
        $result['msg'] = "Failed";
        $result['msg_detail'] = "unexpected error";
    }
    echo json_encode($result); 
?>