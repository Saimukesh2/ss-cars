<?php 


function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = ENCRYPT_METHOD;
    $secret_key = SECRET_KEY; // user define private key
    $secret_iv = SECRET_IV; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function sanitize_input($data, $sanitize_type) {
    $input = trim($data);
    
    switch ($sanitize_type) {
        case "int":
            // Sanitize integer input
            $sanitized_input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        break;
        case "float":
            // Sanitize float input
            $sanitized_input = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND);
        break;
        case "string":
            // Sanitize string input
            //$sanitized_input = filter_var($input, FILTER_SANITIZE_STRING);
            $sanitized_input = $input;
            break;

        case "email":
            // Sanitize email input
            $sanitized_input = filter_var($input, FILTER_SANITIZE_EMAIL);
            break;
        case "text":
            // Sanitize textarea input
           // $sanitized_input = filter_var($input, FILTER_SANITIZE_STRING);
            // Optionally, strip HTML tags depending on your application's requirements
            $sanitized_input = $input;
            $sanitized_input = strip_tags($sanitized_input);
        break;
    
        case "textarea":
            // Sanitize textarea input
            //$sanitized_input = filter_var($input, FILTER_SANITIZE_STRING);
            // Optionally, strip HTML tags depending on your application's requirements
            $sanitized_input = $input;
            $sanitized_input = strip_tags($sanitized_input);
            break;

        case "url":
            // Sanitize URL input
            $sanitized_input = filter_var($input, FILTER_SANITIZE_URL);
            break;

        default:
            // Default to basic string sanitization
            $sanitized_input = $input;
            $sanitized_input = strip_tags($sanitized_input);
            break;
    }

    return $sanitized_input;
}

function getMessage($code)
{
     switch($code){
        case "ERR01":
            return "You have entered an invalid user id / password. Please try again or contact administrator.";
        break;
        case "ERR02":
            return "Your previous session has timed out for security reasons. Please login again.";
        break;
        case "ERR03":
            return "Please enter all the missing fields.";
        break;
        case "SUC01":
            return "Product category added successfully.";
        break;
        case "SUC02":
            return "Product category updated successfully.";
        break;
        case "SUC03":
            return "Product sub-category added successfully.";
        break;
        case "SUC04":
            return "Product sub-category updated successfully.";
        break;
        case "SUC05":
            return "Location added successfully.";
        break;
        case "SUC06":
            return "Location updated successfully.";
        break;
        case "SUC07":
            return "UOM added successfully.";
        break;
        case "SUC08":
            return "UOM updated successfully.";
        break;
        case "SUC09":
            return "Product added successfully.";
        break;
        case "SUC10":
            return "Product updated successfully.";
        break;
        case "SUC11":
            return "Vendor added successfully.";
        break;
        case "SUC12":
            return "Vendor updated successfully.";
        break;
        case "SUC13":
            return "User Group added successfully.";
        break;
        case "SUC14":
            return "User Group updated successfully.";
        break;
        case "SUC15":
            return "User added successfully.";
        break;
        case "SUC16":
            return "User updated successfully.";
        break;
        case "SUC17":
            return "Product dimensions updated successfully.";
        break;
        case "SUC18":
            return "Product cost updated successfully.";
        break;
        case "SUC19":
            return "Product added successfully.";
        break;
        case "SUC20":
            return "Manufacturer added successfully.";
        break;
        case "SUC21":
            return "Manufacturer updated successfully.";
        break;
        case "SUC22":
            return "Product updated successfully.";
        break;

        case "SUCSI":
            return "Stock Inward added successfully.";
        break;
        case "SUC_PRIVILEGES_UPDATED":
            return "User privileges updated successfully.";
        break;
        case "ERRTOTALMISMATCH":
            return "There is a mismatch between gross total and vendor bill amount. Please check and update.";
        break;
        case "ERRLOCATIONDUPLICATE":
            return "Location name already exists.";
        break;
        case "ERRCATEGORYCODEDUPLICATE":
            return "Product category code already exists.";
        break;
        case "ERRUOMDUPLICATE":
            return "UOM already exists.";
        break;
        case "ERRUGDUPLICATE":
            return "User Group already exists.";
        break;
        case "ERRUSRDUPLICATE":
            return "User name already exists.";
        break;
        case "ERRPRODUCTCODEDUPLICATE":
            return "Product code already exists.";
        break;
        case "ERRPRODUCTNAMEDUPLICATE":
            return "Product name already exists.";
        break;
        case "ERRVENDUPLICATE":
            return "Vendor name already exists.";
        break;
        case "ERRCATEGORYCODE":
            return "Product category code do not exist.";
        break;
        case "ERRCATEMPTY":
            return "Category trying to edit seems to be invalid.";
        break;
        case "ERRMODEMPTY":
            return "Model trying to edit seems to be invalid.";
        break;
        case "ERRSUBCATEMPTY":
            return "Product sub-category trying to edit seems to be invalid.";
        break;
        case "ERRUOMEMPTY":
            return "UOM trying to edit seems to be invalid.";
        break;
        case "ERRPDEMPTY":
            return "Product ID trying to edit seems to be invalid";
        break;
        case "ERRCATUPDATE":
            return "No update is done for the edited product category.";
        break;
        case "ERRSUBCATUPDATE":
            return "No update is done for the edited product sub-category.";
        break;
        case "ERRUOMEUPDATE":
            return "No update is done for the edited UOM.";
        break;
        case "ERRSIDUPLICATE":
            return "The product code is already added.";
        break;
        case 'SUCDELITEM':
            return "Item deleted successfully";
        break;
        case "ERRTAGPROD":
            return "Invalid Product code, please try tagging products again.";
        break;
        case "ERRINVALID":
            return "The page you are trying to access is invalid.";
        break;
        case "ERRCATNAME":
            return "Category name cannot be null";
        break;
        case "ERRMODNAME":
            return "Model name cannot be null";
        break;
        case "ERRCARNAME":
            return "Car name cannot be null";
        break;
        case "ERREMPNAME":
            return "Employee name cannot be null";
        break;
        case "ERRCUSTNAME":
            return "Customer name cannot be null";
        break;
        case "ERRCATINS":
            return "Category cannot be added due to unexecpted error. Please try again.";
        break;
        case "ERRMODINS":
            return "Models cannot be added due to unexecpted error. Please try again.";
        break;
        case "ERRMODIMGTYPE":
            return "Please select a valid JPG, JPEG, or PNG model image.";
        break;
        case "ERRMODIMGUPLOAD":
            return "The model image could not be uploaded. Choose an image no larger than 5 MB and try again.";
        break;
        case "ERREMPINS":
            return "Employee cannot be added due to unexecpted error. Please try again";
        break;
        case "SUCCATINS":
            return "Category added successfully.";
        break;
        case "ERRCATIMGTYPE":
            return "Please select a valid JPG, JPEG, or PNG image.";
        break;
        case "ERRCATIMGUPLOAD":
            return "The category image could not be uploaded. Choose an image no larger than 5 MB and try again.";
        break;
        case "ERRCARIMGTYPE":
            return "Please select a valid JPG, JPEG, or PNG car image.";
        break;
        case "ERRCARIMGUPLOAD":
            return "The car image could not be uploaded. Choose an image no larger than 5 MB and try again.";
        break;
        case "SUCCCARINS":
            return "Car added successfully.";
        break;
        case "ERRCARINS":
            return "Car cannot be added due to unexecpted error. Please try again.";
        break;
        case "SUCCEMPINS":
            return "Employee added successfully.";
        break;
        case "SUCCCUSTINS":
            return "Customer added successfully.";
        break;
        case "SUCCATUPD":
            return "Category updated successfully.";
        break;
        case "SUCMODUPD":
            return "Model updated successfully.";
        break;
        case "SUCCCARUPD":
            return "Car updated successfully.";
        break;
        case "SUCCEMPUPD":
            return "Employee updated successfully.";
        break;
        case "SUCCCUSTUPD":
            return "Customer updated successfully.";
        break;
        case "ERREMPUPD":
            return "Employee cannot be updated due to unexcepted error. Please try again.";
        break;
        case "ERRCATUPD":
            return "Category cannot be updated due to unexecpted error. Please try again.";
        break;
        case "ERRMODUPD":
            return "Models cannot be updated due to unexecpted error. Please try again.";
        break;
        case "ERRCARUPD":
            return "Car cannot be updated due to unexected error.Please try again.";
        break;
        case "SUCCMODINS":
            return "Models added successfully.";
        break;
        case "ERRCUSTINS":
            return "Customer cannot be added due to unexecpted error. Please try again.";
        break;
        case "SUCCENQUPD":
            return "Enquiry Updated Successfully.";
        break;
        case "SUCCSERVUPD":
            return "Service Updated Successfully.";
        break;
        case "ERRSERVUPD":
            return "Service cannot be updated due to unexecpted error. Please try again.";
        break;
        case "ERRSERVEMPTY":
            return "Service trying to edit seems to be invalid.";
        break;
        case "ERRENQUPD":
            return "Enquiry cannot be updated due to unexecprted error.Please try again.";
        break;
        case "SUCCSALEUPD":
            return "Sale Updated Successfully.";
        break;
        case "ERRSALEUPD":
            return "Sale cannot be updated due to unexecpted error. Please try again.";
        break;
        case "SUCCENQINS":
            return "Enquiry added successfully.";
        break;
        case "SUCCSALEINS":
            return "Sale added successfully.";
        break;
        case "SUCCSERVINS":
            return "Service added Successfully.";
        break;
        case "ERRSERVINS":
            return "Service cannot be added due to unexecpted error.Please try again.";
        break;
        case "ERRENQINS":
            return "Enquiry cannot be added due to unexecpted error. Please try again.";
        break;
        case "ERRSALEINS":
            return "Sale cannot be added due to unexecpted error. Please try again.";
        break;
        case "ERRENQNAME":
            return "Customer Name cannot be null";
        break;
        case "ERRCATDUP":
            return "Category name already exists.";
        break;
        case "ERRMODDUP":
            return "Model name already exists.";
        break;
        default: 
            return "Unexpected error occured";
        break;
    }
}

//function to get user_gid from session variable
function getUserGID()
{
    $login_name = $_SESSION['SESS_USERLOGIN_ID'];
    $dbcon = new db();
    $sql = $dbcon->query("SELECT user_gid FROM gk_mst_tuser WHERE login_name =? LIMIT 1",$login_name);
    $arrUser = $sql->fetchArray();
    if(!empty($arrUser)){   
        $user_gid = $arrUser['user_gid'];
    }else{
        $user_gid = 0;
    }
    return $user_gid;
}

//function used to select all Countries
function loadCountries(){
    $dbcon = new db();

    $rs_countries = $dbcon->query('SELECT * FROM tbl_countries order by countryname');
    $arrcountries = $rs_countries->fetchAll();
    $dbcon->close();
    return $arrcountries;
}

//function used to select all Countries
function loadAllStates(){
    $dbcon = new db();

    $rs_states = $dbcon->query('SELECT * FROM tbl_states order by country_id,statename');
    $arrstates = $rs_states->fetchAll();
    $dbcon->close();
    return $arrstates;
}

//function used to select all Countries
function loadStates($countryid){
    $dbcon = new db();
    $rs_state = $dbcon->query('SELECT * FROM tbl_states where country_id= ? order by statename',$countryid);
    $arrstates = $rs_state->fetchAll();
    $dbcon->close();
    return $arrstates;
}

//function used to select particular country
function getCountry($country_gid){
    $dbcon = new db();
    $rs_selectcountry = $dbcon->query('SELECT countryname 
                                     FROM tbl_countries
                                     WHERE country_id =?',
                                     $country_gid);
    $arrCountry = $rs_selectcountry->fetchArray();
    $dbcon->close();
    return $arrCountry['countryname'];
}

//function used to select particular state
function getState($state_gid){
    $dbcon = new db();
    $rs_selectstate = $dbcon->query('SELECT statename 
                                     FROM tbl_states
                                     WHERE state_id =?',
                                     $state_gid);
    $arrState = $rs_selectstate->fetchArray();
    $dbcon->close();
    return $arrState['statename'];
}

//function used to select particular city
function getCity($city_gid){
    $dbcon = new db();
    $rs_selectcity = $dbcon->query('SELECT city 
                                     FROM tbl_city
                                     WHERE city_id =?',
                                     $city_gid);
    $arrcity = $rs_selectcity->fetchArray();
    $dbcon->close();
    return $arrcity['city'];
}

//function used to select cities
function loadCities($state){
    $dbcon = new db();
    $rs_city = $dbcon->query('SELECT * FROM tbl_city where state_id= ? order by city',$state);
    $arrcities = $rs_city->fetchAll();
    $dbcon->close();
    return $arrcities;
}

function convertToMySQLDate($dateStr) {
    $date = DateTime::createFromFormat('d-m-Y', $dateStr);
    return $date->format('Y-m-d');
}

?>