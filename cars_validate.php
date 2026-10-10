<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCar.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['carName']))
    {
        $modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        
        $year = sanitize_input($_POST['year'],'textarea');
        
        $arrColors = $_POST['colorAvailable'];
        $price = sanitize_input($_POST['price'],'textarea');
        
        $features = sanitize_input($_POST['features'],'textarea');
        $mieleage = sanitize_input($_POST['mieleage'],'textarea');
        
        $status = sanitize_input($_POST['status'],'textarea');
        
        $csvColors = implode(",", $arrColors);
        //print_r($_POST);
        //exit;
        
        if($carName != '')
        {
            //check if car name already exists
            $carName_upper = strtoupper($carName);
            //call a db function to check if car name already exists
            $car_count = checkCarExists($carName_upper);
            //exit;
            if($car_count == 0)
            {
                //ready to insert the record
                //storing all form fields in an array
                $arrData = array(
                    //'category_id'=> $categoryID,
                    'model_name'=> $modelName,
                    'car_name'=> $carName,                   
                    'year'=> $year,
                    'color_available'=> $csvColors,
                    'price'=> $price,
                    'features'=> $features,
                    'mieleage'=> $mieleage,
                    'status'=> $status               
                );
                $insertResult = insertCar($arrData);//inserted model data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                    //Success
                    header('location:cars.php?msg=SUCCCARINS&tab_id=listcars');
                }
               else{
                    //Return back to the cars added page with error message
                    header('Location: cars.php?msg=ERRCARINS&tab_id=addcars');
                }
            }
            else{
                //Car name already exists
                header('Location: cars.php?msg=ERRCARNAME&tab_id=addcars');
            }
        }
    }
    else{
        //Invalid access of this page. Redirect to Car with error code ERR
        header('location:cars.php?msg=ERR');
    }
?>