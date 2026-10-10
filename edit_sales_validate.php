<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageSales.php');
    if(isset($_POST['paymentmethod']))
    {
        $categoryName = sanitize_input($_POST['categoryName'],'textarea');
        $modelName = sanitize_input($_POST['modelName'],'textarea');
        $carName = sanitize_input($_POST['carName'],'textarea');
        $year = sanitize_input($_POST['year'],'textarea');
        $saledate = sanitize_input($_POST['saledate'],'textarea');
        $saleprice = sanitize_input($_POST['saleprice'],'textarea');
        $paymentmethod = sanitize_input($_POST['paymentmethod'],'textarea');
        $enc_sale_id = sanitize_input($_POST['hdnSalesID'],'textarea');
        $sale_id = encrypt_decrypt($enc_sale_id,'decrypt');
        //print_r($_POST);
        //exit;

        $arrData = array(
            'category_name'=> $categoryName,
            'model_name'=> $modelName,
            'car_name'=> $carName,
            'year'=> $year,
            'sale_date'=> $saledate,
            'sale_price'=> $saleprice,
            'payment_method'=> $paymentmethod,
            'sale_id'=> $sale_id
        );
        $updateResult = updateSales($arrData);//insert enquiry data into database
        //Check if affected rows is greater than 0 to confirm ipdate is successful
        if($updateResult > 0)
        {
            //Success
            header('location: sales.php?msg=SUCCSALEUPD&tab_id=listSale');
        }
        else{
            //Return back to sale page with error message
            header('location: sales.php?msg=ERRSALEUPD&tab_id=listSale');
        }
    }
    else{
        //Invalid access of this page.Redirct to sale page with error message
        header('location: sales.php?msg=ERR');
    }
?>
