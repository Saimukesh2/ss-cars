<?php   
    session_start();    
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCustomer.php');
    //print_r($_POST);
    //exit;
    if(isset($_POST['customerName']))
    {
        $customerName = sanitize_input($_POST['customerName'],'textarea');
        $address = sanitize_input($_POST['address'],'textarea');
        $phone = sanitize_input($_POST['phone'],'textarea');
        $mailid = sanitize_input($_POST['mailid'],'textarea');
        $gender = sanitize_input($_POST['gender'],'textarea');
        $age = sanitize_input($_POST['age'],'textarea');
        $dateofbirth = sanitize_input($_POST['dateofbirth'],'textarea');
        $city = sanitize_input($_POST['city'],'textarea');
        $state = sanitize_input($_POST['state'],'textarea');
        //print_r($_POST);
        //exit;
        if($customerName != '')
        {
            //check if customer name already exists
            $customerName_upper = strtoupper($customerName);
            //call a db function to check if customer name already exits
            $customer_count = checkCustomerExists($customerName_upper);
            if($customer_count == 0)
            {
                //ready to insert a record
                //storing all the form field in an array
                $arrData = array(
                    'customer_name'=> $customerName,
                    'address'=> $address,
                    'phone'=> $phone,
                    'mail_id'=> $mailid,
                    'gender'=> $gender,
                    'age'=> $age,
                    'dob'=> $dateofbirth,
                    'city'=> $city,
                    'state'=> $state
                );
                $insertResult = insertCustomer($arrData);//insert model data into database
                //Check if affected rows is 1 to confirm insert is successful
                if($insertResult == 1)
                {
                    //Success
                    header('location: customer.php?msg=SUCCCUSTINS&tab_id=listCust');
                }
                else{
                    //return to the customer page with error message
                    header('location: customer.php?msg=ERRCUSTINS&tab_id=listCust');
                }
            }
            else{
                //customer name already exists
                header('location: customer.php?msg=ERRCUSTNAME&tab_id=addCust');
            }
        }
        else{
            //invalid to access the page.Redirect to customer page with error message
            header('location: customer.php?msg=ERR');
        }

    }