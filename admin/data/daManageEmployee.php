<?php
function insertEmployee($arrData)
{
    //unpack the array arrData
    $employee_name = $arrData['employee_name'];
    $mail_id = $arrData['mail_id'];
    $address = $arrData['address'];
    $phone = $arrData['phone'];
    $position = $arrData['position'];
    $hire_date = $arrData['hire_date'];
    $gender = $arrData['gender'];
    $age = $arrData['age'];
    $dob = $arrData['dob'];
    $user_name = $arrData['user_name'];
    $password = $arrData['password'];
    //open the db connection
    $dbcon = new db();
    $sql =$dbcon->query("INSERT INTO `ss_trn_employee`
                            (        `employee_name`,
                                     `mail_id`,
                                     `address`,
                                     `phone`,
                                     `position`,
                                     `hire_date`,
                                     `gender`,
                                     `age`,
                                     `dob`,
                                     `user_name`,
                                     `password`
                            )
                            VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                            $employee_name,
                            $mail_id,
                            $address,   
                            $phone,
                            $position,
                            $hire_date,
                            $gender,
                            $age,
                            $dob,
                            $user_name,
                            $password
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}



function getAllEmployee()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT employee_id,
                                 employee_name,
                                 phone,
                                 mail_id,
                                 position,
                                 hire_date,
                                 gender,
                                 age,
                                 user_name,
                                 password
                          FROM ss_trn_employee');
    $arrEmployee = $sql->fetchAll();
    $dbcon->close();
    return $arrEmployee;

}

function getEmployeeById($employee_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_employee WHERE employee_id = ? LIMIT 1", $employee_id);
    $arrEmployee = $sql->fetchArray();
    $dbcon->close();
    return $arrEmployee;
}

function checkEmployeeExists($employeeName_upper)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM `ss_trn_employee` WHERE UPPER(`employee_name`) = ?", $employeeName_upper);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}

function updateEmployee($arrData)
{
    //$employee_name = $arrData['employee_name'];
    $mail_id = $arrData['mail_id'];
    $address = $arrData['address'];
    $phone = $arrData['phone'];
    $position = $arrData['position'];
    $hire_date = $arrData['hire_date'];
    $gender = $arrData['gender'];
    $age = $arrData['age'];
    $dob = $arrData['dob'];
    $user_name = $arrData['user_name'];
    $password = $arrData['password'];
    $employee_id = $arrData['employee_id'];
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("UPDATE `ss_trn_employee` SET 
                                                       `mail_id` = ?,
                                                       `address` = ?,
                                                       `phone` = ?,
                                                       `position` = ?,
                                                       `hire_date` = ?,
                                                       `gender` = ?,
                                                       `age` = ?,
                                                       `dob` = ?,
                                                       `user_name` = ?,
                                                       `password` = ? 
                                                    WHERE `employee_id`  = ?",
                                                   // $employee_name,
                                                    $mail_id,
                                                    $address,
                                                    $phone,
                                                    $position,
                                                    $hire_date,
                                                    $gender,
                                                    $age,
                                                    $dob,
                                                    $user_name,
                                                    $password,
                                                    $employee_id
                            );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}
function deleteEmployee($employee_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM `ss_trn_employee` WHERE `employee_id` = ?", $employee_id);
    $count = $sql->affectedRows();
    $dbcon->close();
    return $count;
}
function getAllActiveEmployeeById()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT `employee_id`, `employee_name` FROM `ss_trn_employee` WHERE `employee_id` > 0");
    $arrEmployee = $sql->fetchAll();
    $dbcon->close();
    return $arrEmployee;
}




































?>