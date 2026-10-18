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
        $existingModel = getModelsById($model_id);
        if (empty($existingModel))
        {
            header('location:models.php?msg=ERRMODEMPTY');
            exit;
        }

        $modelImage = '';
        $uploadedImagePath = '';
        $editPageUrl = 'edit_models.php?' . http_build_query(array('id' => $enc_model_id));
        if (isset($_FILES['modelImage']) && $_FILES['modelImage']['error'] != UPLOAD_ERR_NO_FILE)
        {
            $imageUpload = $_FILES['modelImage'];
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            $allowedMimeTypes = array('image/jpeg', 'image/png');
            $fileExtension = strtolower(pathinfo($imageUpload['name'], PATHINFO_EXTENSION));
            $imageInfo = $imageUpload['error'] == UPLOAD_ERR_OK && $imageUpload['size'] <= 5 * 1024 * 1024
                ? getimagesize($imageUpload['tmp_name'])
                : false;
            if ($imageUpload['error'] != UPLOAD_ERR_OK || $imageUpload['size'] > 5 * 1024 * 1024)
            {
                header('location:' . $editPageUrl . '&msg=ERRMODIMGUPLOAD');
                exit;
            }

            if (!in_array($fileExtension, $allowedExtensions, true) || $imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes, true))
            {
                header('location:' . $editPageUrl . '&msg=ERRMODIMGTYPE');
                exit;
            }

            $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'models';
            if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory))
            {
                error_log('Unable to create the model image upload directory.');
                header('location:' . $editPageUrl . '&msg=ERRMODIMGUPLOAD');
                exit;
            }

            $imageFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
            $uploadedImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $imageFileName;
            if (!is_uploaded_file($imageUpload['tmp_name']) || !move_uploaded_file($imageUpload['tmp_name'], $uploadedImagePath))
            {
                error_log('Unable to save an uploaded model image.');
                header('location:' . $editPageUrl . '&msg=ERRMODIMGUPLOAD');
                exit;
            }

            $modelImage = 'images/models/' . $imageFileName;
        }

        $arrData = array(
            //'model_id' => $modelID,
            'model_status' => $modelStatus,
            'model_desc' => $modelDesc,
            'model_id' => $model_id,
            'model_image' => $modelImage
        );
        $updateResult = updateModels($arrData);//insert model data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
             if ($modelImage != '' && !empty($existingModel['model_image']) && strpos($existingModel['model_image'], 'images/models/') === 0)
             {
                 $oldImagePath = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . basename($existingModel['model_image']);
                 if (is_file($oldImagePath) && !unlink($oldImagePath))
                 {
                     error_log('Unable to remove the replaced model image.');
                 }
             }
             //Success
             header('location:models.php?msg=SUCMODUPD&tab_id=listmodel');
             exit;
        }
        else{
            if ($uploadedImagePath != '' && file_exists($uploadedImagePath) && !unlink($uploadedImagePath))
            {
                error_log('Unable to remove an uploaded model image after the model update failed.');
            }
            //Return back to models page wtih error message
            header('Location:' . $editPageUrl . '&msg=ERRMODUPD');
            exit;
        }
    }
    else{
        //Invalid access of this page. Redirect to models with error code ERR
        header('location:models.php?msg=ERR');
        exit;
    }




















    
?>