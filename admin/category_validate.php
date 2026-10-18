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
        $categoryImage = '';
        $uploadedImagePath = '';

        if($categoryName != '')
        {
            //Check if the category name is not already added / exists
            $categoryName_upper = strtoupper($categoryName);
            //Call a db function to compare category name already exists.
            $category_count = checkCategoryExists($categoryName_upper);

            if($category_count == 0)
            {
                if (isset($_FILES['categoryImage']) && $_FILES['categoryImage']['error'] != UPLOAD_ERR_NO_FILE)
                {
                    $imageUpload = $_FILES['categoryImage'];
                    $allowedExtensions = array('jpg', 'jpeg', 'png');
                    $allowedMimeTypes = array('image/jpeg', 'image/png');
                    $fileExtension = strtolower(pathinfo($imageUpload['name'], PATHINFO_EXTENSION));
                    $imageInfo = $imageUpload['error'] == UPLOAD_ERR_OK && $imageUpload['size'] <= 5 * 1024 * 1024
                        ? getimagesize($imageUpload['tmp_name'])
                        : false;

                    if ($imageUpload['error'] != UPLOAD_ERR_OK || $imageUpload['size'] > 5 * 1024 * 1024)
                    {
                        header('location:category.php?msg=ERRCATIMGUPLOAD&tab_id=addPage');
                        exit;
                    }

                    if (!in_array($fileExtension, $allowedExtensions, true) || $imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes, true))
                    {
                        header('location:category.php?msg=ERRCATIMGTYPE&tab_id=addPage');
                        exit;
                    }

                    $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'categories';
                    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory))
                    {
                        error_log('Unable to create the category image upload directory.');
                        header('location:category.php?msg=ERRCATIMGUPLOAD&tab_id=addPage');
                        exit;
                    }

                    $imageFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
                    $uploadedImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $imageFileName;
                    if (!is_uploaded_file($imageUpload['tmp_name']) || !move_uploaded_file($imageUpload['tmp_name'], $uploadedImagePath))
                    {
                        error_log('Unable to save an uploaded category image.');
                        header('location:category.php?msg=ERRCATIMGUPLOAD&tab_id=addPage');
                        exit;
                    }

                    $categoryImage = 'images/categories/' . $imageFileName;
                }

                //Ready to insert into the database
                //storing all form field values into an array
                $arrData = array(
                    'category_name' => $categoryName,
                    'category_desc' => $categoryDesc,
                    'category_status' => $categoryStatus,
                    'category_image' => $categoryImage
                );
                $insertResult = insertCategory($arrData); //inserted category data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                   //Success
                    header('location:category.php?msg=SUCCATINS&tab_id=listCat');
                    exit;
                }
                else
                {
                    if ($uploadedImagePath != '' && file_exists($uploadedImagePath) && !unlink($uploadedImagePath))
                    {
                        error_log('Unable to remove an uploaded category image after the category insert failed.');
                    }
                    //Return back to category add page wtih error message
                    header('location:category.php?msg=ERRCATINS&tab_id=addPage');
                    exit;
                }
            }
            else{
                //Category Name already exists. Redirect to category add page with error message
                header('location:category.php?msg=ERRCATDUP&tab_id=addPage');
                exit;
            }
        }
        else
        {
            //Category Name is null. so redirect with warning
            header('location:category.php?msg=ERRCATNAME&tab_id=addPage');    
            exit;
        }
        //print_r($_POST);//Print all the posted values
    }
    else
    {
        //Invalid access of this page. Redirect to category with error code ERR
        header('location:category.php?msg=ERR');
        exit;
    }
    

?>