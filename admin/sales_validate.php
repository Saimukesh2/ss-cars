<?php   
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageSales.php');
    if(isset($_POST['employeeName']))
    {
        //$categoryName = sanitize_input($_POST['categoryName'],'textarea');
        //$modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        $year = sanitize_input($_POST['year'],'textarea');
        $employeeName = sanitize_input($_POST['employeeName'],'textarea');
        $customerName = sanitize_input($_POST['customerName'],'textarea');
        $saledate = sanitize_input($_POST['saledate'],'textarea');
        $saleprice = sanitize_input($_POST['saleprice'],'textarea');
        $paymentmethod = sanitize_input($_POST['paymentmethod'],'textarea');
        //print_r($_POST);
        //exit;
        
        $arrData = array(
            'car_name'=> $carName,
            'employee_name'=> $employeeName,
            'customer_name'=> $customerName,
            'sale_date'=> $saledate,
            'sale_price'=> $saleprice,
            'payment_method'=> $paymentmethod
        );
        $insertResult = insertSales($arrData);//inserted sales into database
       //check if affected rows is 1 to confirm insert is successful
       if($insertResult == 1)
       {
            //Success
            header('location: sales.php?msg=SUCCSALEINS&tab_id=listSale');
       }
       else{
            //Error
        header('location: sales.php?msg=ERRSALEINS&tab_id=addSale');
       }

    }
    else{
        //Invalid access of this page. Redirect to employee with error code ERR
        header('location: sales.php?msg=ERR');
    }
?>

