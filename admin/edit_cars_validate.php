<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('common/car_image_upload.php');
    require_once('data/daManageCar.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['features']))
    {
        //Form parameters are posted. Lets proceed
        $features = sanitize_input($_POST['features'],'textarea');
        //$model_id = sanitize_input($_POST['model_id'], 'textarea');
        $year = sanitize_input($_POST['year'], 'textarea');
        $arrColors = isset($_POST['colorAvailable']) ? $_POST['colorAvailable'] : array();
        $price = sanitize_input($_POST['price'], 'textarea');
        $mieleage = sanitize_input($_POST['mieleage'], 'textarea');
        $status = sanitize_input($_POST['status'], 'textarea');
        $enc_car_id = sanitize_input($_POST['hdnCarID'],'textarea');
        $car_id = encrypt_decrypt($enc_car_id,'decrypt');
        $existingCar = getCarById($car_id);
        if (empty($existingCar))
        {
            header('location:cars.php?msg=ERRCAREMPTY');
            exit;
        }

        $carImage = '';
        $uploadedImagePath = '';
        $editPageUrl = 'edit_cars.php?' . http_build_query(array('id' => $enc_car_id));
        if (isset($_FILES['carImage']) && $_FILES['carImage']['error'] != UPLOAD_ERR_NO_FILE)
        {
            $imageResult = saveCarImageUpload($_FILES['carImage']);
            if ($imageResult['error'] != '')
            {
                header('Location: ' . $editPageUrl . '&msg=' . $imageResult['error']);
                exit;
            }
            $carImage = $imageResult['path'];
            $uploadedImagePath = $imageResult['absolute_path'];
        }

        $arrData = array(
            'features'=> $features,
            //'car_id'=> $carID,
            'year'=> $year,
            'color_available'=> $arrColors,
            'price'=> $price,
            'mieleage'=> $mieleage,
            'status'=> $status,
            'car_id'=> $car_id,
            'car_image'=> $carImage
        );
        $updateResult = updateCar($arrData);//insert model data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            if ($carImage != '' && !empty($existingCar['car_image']) && strpos($existingCar['car_image'], 'images/cars/') === 0)
            {
                $oldImagePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cars' . DIRECTORY_SEPARATOR . basename($existingCar['car_image']);
                if (is_file($oldImagePath) && !unlink($oldImagePath))
                {
                    error_log('Unable to remove the replaced car image.');
                }
            }
            //Success
            header('location: cars.php?msg=SUCCCARUPD&tab_id=listcars');
            exit;
        }
        else{
            if ($uploadedImagePath != '' && is_file($uploadedImagePath) && !unlink($uploadedImagePath))
            {
                error_log('Unable to remove an uploaded car image after the car update failed.');
            }
            //Return back to cars page with error message
            header('Location: ' . $editPageUrl . '&msg=ERRCARUPD');
            exit;
        }
    }
    else{
        //Invalid access of this page. Redirect to cars with error code ERR
        header('location: cars.php?msg=ERR');
        exit;
    }