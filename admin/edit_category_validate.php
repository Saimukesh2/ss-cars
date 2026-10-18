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
        $existingCategory = getCategoryById($category_id);
        if (empty($existingCategory))
        {
            header('location:category.php?msg=ERRCATEMPTY');
            exit;
        }

        $categoryImage = '';
        $uploadedImagePath = '';
        $editPageUrl = 'edit_category.php?' . http_build_query(array('id' => $enc_category_id));
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
                header('location:' . $editPageUrl . '&msg=ERRCATIMGUPLOAD');
                exit;
            }

            if (!in_array($fileExtension, $allowedExtensions, true) || $imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes, true))
            {
                header('location:' . $editPageUrl . '&msg=ERRCATIMGTYPE');
                exit;
            }

            $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'categories';
            if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory))
            {
                error_log('Unable to create the category image upload directory.');
                header('location:' . $editPageUrl . '&msg=ERRCATIMGUPLOAD');
                exit;
            }

            $imageFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
            $uploadedImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $imageFileName;
            if (!is_uploaded_file($imageUpload['tmp_name']) || !move_uploaded_file($imageUpload['tmp_name'], $uploadedImagePath))
            {
                error_log('Unable to save an uploaded category image.');
                header('location:' . $editPageUrl . '&msg=ERRCATIMGUPLOAD');
                exit;
            }

            $categoryImage = 'images/categories/' . $imageFileName;
        }

        $arrData = array(
            'category_desc' => $categoryDesc,
            'category_status' => $categoryStatus,
            'category_id' => $category_id,
            'category_image' => $categoryImage
        );
        $updateResult = updateCategory($arrData); //inserted category data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            if ($categoryImage != '' && !empty($existingCategory['category_image']) && strpos($existingCategory['category_image'], 'images/categories/') === 0)
            {
                $oldImagePath = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR . basename($existingCategory['category_image']);
                if (is_file($oldImagePath) && !unlink($oldImagePath))
                {
                    error_log('Unable to remove the replaced category image.');
                }
            }
            //Success
            header('location:category.php?msg=SUCCATUPD&tab_id=listCat');
            exit;
        }
        else
        {
            if ($uploadedImagePath != '' && file_exists($uploadedImagePath) && !unlink($uploadedImagePath))
            {
                error_log('Unable to remove an uploaded category image after the category update failed.');
            }
            //Return back to category add page wtih error message
            header('location:' . $editPageUrl . '&msg=ERRCATUPD');
            exit;
        }
    }
    else
    {
        //Invalid access of this page. Redirect to category with error code ERR
        header('location:category.php?msg=ERR');
    }
?>





