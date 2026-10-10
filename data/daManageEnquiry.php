<?php
function insertEnquiry($arrData)
{
    //unpack the array arrData
   /* $category_name = $arrData['category_name'];
    $model_name = $arrData['model_name'];*/
    $car_name = $arrData['car_name'];
    $employee_name = $arrData['employee_name'];
    $customer_name = $arrData['customer_name'];
    $phone = $arrData['phone'];
    $testdrive_willing = $arrData['testdrive_willing'];
    $testdrive_date = $arrData['testdrive_date'];
    $feedback = $arrData['feedback'];
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("INSERT INTO `ss_trn_enquiry`
                               (      `car_id`,
                                      `employee_id`,
                                      `enquirer_name`,
                                      `phone`,
                                      `testdrive_willing`,
                                      `testdrive_date`,
                                      `feedback`
                                )
                                VALUE (?, ?, ?, ?, ?, ?, ?)",
                                $car_name,
                                $employee_name,
                                $customer_name,
                                $phone,
                                $testdrive_willing,
                                $testdrive_date,
                                $feedback
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}
function updateEnquiry($arrData)
{
    $carName = $arrData['car_name'];
    $customerName = $arrData['customer_name'];
    $phone = $arrData['phone'];
    $testdrive_willing = $arrData['testdrive_willing'];
    $testdrive_date = $arrData['testdrive_date'];
    $feedback = $arrData['feedback'];
    $enquiry_id = $arrData['enquiry_id'];
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("UPDATE `ss_trn_enquiry` SET `car_id` = ?,
                                                      `enquirer_name` = ?,
                                                      `phone` = ?,
                                                      `testdrive_willing` = ?,
                                                      `testdrive_date` = ?,
                                                      `feedback` = ?
                                                    WHERE `enquiry_id` = ?",
                                                    $carName,
                                                    $customerName,
                                                    $phone,
                                                    $testdrive_willing,
                                                    $testdrive_date,
                                                    $feedback,
                                                    $enquiry_id
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
    
}
function deleteEnquiry($enquiry_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM `ss_trn_enquiry` WHERE `enquiry_id` = ?", $enquiry_id);
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}
function getAllEnquiry()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT a.enquiry_id,
                                 d.category_name,
                                 c.model_name,
                                 b.car_name,
                                 f.employee_name,
                                 a.enquirer_name,
                                 a.phone,
                                 a.testdrive_willing,
                                 a.testdrive_date
                          FROM ss_trn_enquiry a
                          INNER JOIN ss_mst_car b
                          ON a.car_id=b.car_id
                          INNER JOIN ss_mst_models c
                          ON b.model_id=c.model_id
                          INNER JOIN ss_mst_category d
                          ON c.category_id=d.category_id
                          INNER JOIN ss_trn_employee f
                          ON a.employee_id=f.employee_id;');
    $arrEnquiry = $sql->fetchAll();
    $dbcon->close();
    return $arrEnquiry;
}

function getEnquiryById($enquiry_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.enquiry_id,a.car_id,a.employee_id,d.category_id,d.category_name,c.model_id,c.model_name,b.car_name,e.employee_name,
                                 a.enquirer_name,a.phone,a.testdrive_willing,a.testdrive_date,a.feedback
                          FROM ss_trn_enquiry a
                          INNER JOIN ss_mst_car b
                          ON a.car_id=b.car_id
                          INNER JOIN ss_mst_models c
                          ON b.model_id=c.model_id
                          INNER JOIN ss_mst_category d
                          ON c.category_id=d.category_id
                          INNER JOIN ss_trn_employee e
                          ON a.employee_id=e.employee_id
                          WHERE a.enquiry_id = ? LIMIT 1", $enquiry_id);
    $arrEnquiry = $sql->fetchArray();
    $dbcon->close();
    return $arrEnquiry;
}
function getCustomerNames($input, $mode = '')
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.enquirer_name as customer_name
                            FROM ss_trn_enquiry a
                            WHERE a.testdrive_willing =?
                            AND a.enquirer_name LIKE ?",
                            'Yes','%' . $input . '%');
    $result = $sql->fetchAll();
    $matchingCustomers = array();
    foreach ($result as $row) {
        $matchingCustomers[] = $row['customer_name'];
    }
    if ($mode == ''){
        $matchingCustomers = 'New Customer';
    }
    $dbcon->close();
    return $matchingCustomers;
}










































?>