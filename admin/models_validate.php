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
        $modelImage = '';
        $uploadedImagePath = '';
        if($modelName != '')
        {
            //Check if the model name is not already added / exists
            $modelName_upper = strtoupper($modelName);
            //Call a db function to compare model name already exists.
            $model_count = checkModelsExists($modelName_upper);

            if($model_count == 0)
            {
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
                        header('location:models.php?msg=ERRMODIMGUPLOAD&tab_id=addmodel');
                        exit;
                    }

                    if (!in_array($fileExtension, $allowedExtensions, true) || $imageInfo === false || !in_array($imageInfo['mime'], $allowedMimeTypes, true))
                    {
                        header('location:models.php?msg=ERRMODIMGTYPE&tab_id=addmodel');
                        exit;
                    }

                    $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'models';
                    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory))
                    {
                        error_log('Unable to create the model image upload directory.');
                        header('location:models.php?msg=ERRMODIMGUPLOAD&tab_id=addmodel');
                        exit;
                    }

                    $imageFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
                    $uploadedImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $imageFileName;
                    if (!is_uploaded_file($imageUpload['tmp_name']) || !move_uploaded_file($imageUpload['tmp_name'], $uploadedImagePath))
                    {
                        error_log('Unable to save an uploaded model image.');
                        header('location:models.php?msg=ERRMODIMGUPLOAD&tab_id=addmodel');
                        exit;
                    }

                    $modelImage = 'images/models/' . $imageFileName;
                }

                //Ready to insert into the database
                //storing all form field values into an array
                $arrData = array(
                   'category_id' => $categoryID,
                   'model_name' => $modelName,
                   'model_desc' => $modelDesc,
                   'model_status' => $modelStatus,
                   'model_image' => $modelImage
                );
                $insertResult = insertModels($arrData); //inserted model data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                   //Success
                    header('location:models.php?msg=SUCCMODINS&tab_id=listmodel');
                    exit;
                }
                else
                {
                    if ($uploadedImagePath != '' && file_exists($uploadedImagePath) && !unlink($uploadedImagePath))
                    {
                        error_log('Unable to remove an uploaded model image after the model insert failed.');
                    }
                    //Return back to model add page wtih error message
                    header('location:models.php?msg=ERRMODINS&tab_id=addmodel');
                    exit;
                }
            }
            else{
                //Model Name already exists. Redirect to model add page with error message
                header('location:models.php?msg=ERRMODDUP&tab_id=addmodel');
                exit;
            }
            
        }
        else
        {
            //Model Name is null. so redirect with warning
            header('location:models.php?msg=ERRMODNAME&tab_id=addmodel');
            exit;
        }
    }
    else
    {
        //Invalid access of this page. Redirect to Model with error code ERR
        header('location:models.php?msg=ERR');
        exit;
    }
?>