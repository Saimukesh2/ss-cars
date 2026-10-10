<?php 
    session_start(); // Always initialize this in the top
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCar.php');
    //require_once('data/daManageSession.php');

    if(isset($_POST['categoryName']))
    {
        //FOrm parameters are posted. Lets proceed   
        $categoryName = sanitize_input($_POST['categoryName'], 'textarea');
        $categoryDesc = sanitize_input($_POST['description'],'textarea');
        $categoryStatus = sanitize_input($_POST['status'],'textarea');  

        if($categoryName != '')
        {
            //Check if the category name is not already added / exists
            $categoryName_upper = strtoupper($categoryName);
            //Call a db function to compare category name already exists.
            $category_count = checkCategoryExists($categoryName_upper);

            if($category_count == 0)
            {
                //Ready to insert into the database
                //storing all form field values into an array
                $arrData = array(
                    'category_name' => $categoryName,
                    'category_desc' => $categoryDesc,
                    'category_status' => $categoryStatus
                );
                $insertResult = insertCategory($arrData); //inserted category data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                   //Success
                    header('location:category.php?msg=SUCCATINS&tab_id=listCat');
                }
                else
                {
                    //Return back to category add page wtih error message
                    header('location:category.php?msg=ERRCATINS&tab_id=addPage');
                }
            }
            else{
                //Category Name already exists. Redirect to category add page with error message
                header('location:category.php?msg=ERRCATDUP&tab_id=addPage');
            }
        }
        else
        {
            //Category Name is null. so redirect with warning
            header('location:category.php?msg=ERRCATNAME&tab_id=addPage');    
        }
        //print_r($_POST);//Print all the posted values
    }
    else
    {
        //Invalid access of this page. Redirect to category with error code ERR
        header('location:category.php?msg=ERR');
    }
    

?>