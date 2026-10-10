<?php 
/**********************************************************
File Name: daManageLogin.php
Author: karthi
Date: Jul 3, 2022
Desc: Manages all DB functions related to employee Login

Edit By:
Date: 
Desc" 

***********************************************************/
function checkLogin($arrLogin)
{
    //check the login and password combination exists in the database
    //unpack the array

    $user_name = $arrLogin['user_name'];
    $password = $arrLogin['password'] ;

    //Open db connection
    $dbcon = new db();  //Created an object for dbconnection

    $sql = " SELECT * FROM `ss-cars`.ss_trn_employee WHERE user_name = '$user_name' AND password = '$password'"; 
    $result = $dbcon->query($sql);
    //Query is executed. Now I need number of rows returned 
    $count = $result->numRows();
    return $count;

}








?>