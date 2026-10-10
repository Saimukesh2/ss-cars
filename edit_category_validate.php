<?php 
    session_start(); // Always initialize this in the top
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
       // $categoryName = sanitize_input($_POST['categoryName'], 'textarea');
        $categoryDesc = sanitize_input($_POST['description'],'textarea');
        $categoryStatus = sanitize_input($_POST['status'],'textarea');
        $enc_category_id = sanitize_input($_POST['hdnCategoryID'],'textarea');
        $category_id = encrypt_decrypt($enc_category_id,'decrypt');
        $arrData = array(
            'category_desc' => $categoryDesc,
            'category_status' => $categoryStatus,
            'category_id' => $category_id
        );
        $updateResult = updateCategory($arrData); //inserted category data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            //Success
            header('location:category.php?msg=SUCCATUPD&tab_id=listCat');
        }
        else
        {
            //Return back to category add page wtih error message
            header('location:category.php?msg=ERRCATUPD&tab_id=listCat');
        }
    }
    else
    {
        //Invalid access of this page. Redirect to category with error code ERR
        header('location:category.php?msg=ERR');
    }
?>






