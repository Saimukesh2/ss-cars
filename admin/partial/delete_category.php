<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageCar.php');
    $result = array();
    if(isset($_POST))
    {
        $enc_category_id = $_POST['enc_categoryID'];
        $category_id = encrypt_decrypt($enc_category_id,'decrypt');
        //call db function to delete this category
        $count = checkCategoryExistsinModels($category_id);
       
        if($count == 0)
        {
            //count is zero,so we can delete the category
            $affectedRows = deleteCat($category_id);
        if($affectedRows == 1)
        {
            $result['msg'] = 'Success';
            $result['msg_detail'] = 'Category deleted successfully';
        }
        else{
            $result['msg'] = 'Failed';
            $result['msg_detail'] = 'Category delete Failed';
        }       
        }
        else{
            //This Category cannot be deleted as it is having child
            $result['msg'] = 'Failed';
            $result['msg_detail'] = 'Category is Failed to Delete as it is having a Existing Model';
        }
        
    }
    else
    {
        $result['msg'] = 'Failed';
        $result['msg_detail'] = 'unexpected error ';
    } 
   echo json_encode($result);   
?>