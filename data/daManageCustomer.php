<?php
function insertCustomer($arrData)
{
    $dbcon = new db();
    $customer_name = $arrData['customer_name'];
    $address = $arrData['address'];
    $phone = $arrData['phone'];
    $mail_id = $arrData['mail_id'];
    $gender = $arrData['gender'];
    $age = $arrData['age'];
    $dob = $arrData['dob'];
    $city = $arrData['city'];
    $state = $arrData['state'];
    $sql = $dbcon->query("INSERT INTO `ss_trn_customer` (
                                      `customer_name`,
                                      `address`,
                                      `phone`,
                                      `mail_id`,
                                      `gender`,
                                      `age`,
                                      `dob`,
                                      `city`,
                                      `state`
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                    $customer_name,
                                    $address,
                                    $phone,
                                    $mail_id,
                                    $gender,
                                    $age,
                                    $dob,
                                    $city,
                                    $state
                        );
                        
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}


function updateCustomer($arrData)
{
    //print_r($arrData);
    //exit;
    $address = $arrData['address'];
    $phone = $arrData['phone'];
    $mail_id = $arrData['mail_id'];
    $gender = $arrData['gender'];
    $age = $arrData['age'];
    $dob = $arrData['dob'];
    $city = $arrData['city'];
    $state = $arrData['state'];
    $customer_id = $arrData['customer_id'];
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("UPDATE `ss_trn_customer`
              SET `address` = ?,
                  `phone` = ?,
                  `mail_id` = ?,
                  `gender` = ?,
                  `age` = ?,
                  `dob` = ?,
                  `city` = ?,
                  `state` = ?
              WHERE `customer_id` = ?",
                    $address,
                    $phone,
                    $mail_id,
                    $gender,
                    $age,      
                    $dob,
                    $city,
                    $state,
                    $customer_id 
    );

    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    //echo $affectedRows;
    //exit;
    return $affectedRows;    

}

function checkCustomerDependencies($customer_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT ((SELECT COUNT(*) FROM `ss_rpt_sales` WHERE `customer_id` = ?) + (SELECT COUNT(*) FROM `ss_rpt_service` WHERE `customer_id` = ?)) AS `usage_count`", $customer_id, $customer_id);
    $result = $sql->fetchArray();
    $dbcon->close();
    return (int)$result['usage_count'];
}

function deleteCustomer($customer_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM `ss_trn_customer` WHERE `customer_id` = ?", $customer_id);
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;

}

function getAllCustomer()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT customer_id,
                                 customer_name,
                                 phone,
                                 mail_id,
                                 gender,
                                 age,
                                 dob,
                                 city,
                                 state
                          FROM ss_trn_customer');
    $arrCustomer = $sql->fetchAll();
    $dbcon->close();
    return $arrCustomer;
}

function getCustomerById($customer_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_customer WHERE customer_id = ? LIMIT 1", $customer_id);
    $arrCustomer =$sql->fetchArray();
    $dbcon->close();
    return $arrCustomer;
}

function checkCustomerExists($customerName_upper)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM `ss_trn_customer` WHERE UPPER(`customer_name`) = ?", $customerName_upper);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
function getAllActiveCustomerById()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT `customer_id`, `customer_name` FROM `ss_trn_customer` WHERE `customer_id` > 0");
    $arrCustomer = $sql->fetchAll();
    $dbcon->close();
    return $arrCustomer;
}




















?>