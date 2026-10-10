<?php
function insertService($arrData)
{
    $carName = $arrData['car_name'];
    $employeeName = $arrData['employee_name'];
    $customerName = $arrData['customer_name'];
    $sericedate = $arrData['service_date'];
    $servicecost = $arrData['service_cost'];
    $servicetype = $arrData['service_type'];
    $feedback = $arrData['feedback'];
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("INSERT INTO `ss_rpt_service`
                                    ( `car_id`,
                                      `employee_id`,
                                      `customer_id`,
                                      `service_date`,
                                      `service_cost`,
                                      `service_type`,
                                      `feedback`
                                    )
                                    VALUE (?, ?, ?, ?, ?, ?, ?)",
                                    $carName,
                                    $employeeName,
                                    $customerName,
                                    $sericedate,
                                    $servicecost,
                                    $servicetype,
                                    $feedback
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}
function updateService($arrData)
{
    $carName = $arrData['car_name'];
    $servicedate = $arrData['service_date'];
    $servicetype = $arrData['service_type'];
    $servicecost = $arrData['service_cost'];
    $feedback = $arrData['feedback'];
    $service_id = $arrData['service_id'];

    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("UPDATE `ss_rpt_service` SET `car_id` =?,
                                                      `service_date` =?,
                                                      `service_type` =?,
                                                      `service_cost` =?,
                                                      `feedback` =?
                                                    WHERE `service_id` =?",
                                                    $carName,
                                                    $servicedate,
                                                    $servicetype,
                                                    $servicecost,
                                                    $feedback,
                                                    $service_id
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}
function deleteService()
{

}
function getAllService()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT a.service_id,
                                 e.category_name,
                                 d.model_name,
                                 c.car_name,
                                 c.color_available,
                                 c.year,
                                 f.employee_name,
                                 g.customer_name,
                                 a.service_date,
                                 a.service_type,
                                 a.service_cost,
                                 a.feedback
                        FROM ss_rpt_service a
                        INNER JOIN ss_mst_car c
                        ON a.car_id=c.car_id
                        INNER JOIN ss_mst_models d
                        ON c.model_id=d.model_id
                        INNER JOIN ss_mst_category e
                        ON d.category_id=e.category_id
                        INNER JOIN ss_trn_employee f
                        ON a.employee_id=f.employee_id
                        INNER JOIN ss_trn_customer g
                        ON a.customer_id=g.customer_id;');
    $arrService = $sql->fetchAll();
    $dbcon->close();
    return$arrService;                      
}
function getServiceById($service_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.service_id,
                                 a.car_id,
                                 a.employee_id,
                                 a.customer_id,
                                 d.category_id,
                                 c.model_id,
                                 d.category_name,
                                 c.model_name,
                                 b.car_name,
                                 b.year,
                                 e.employee_name,
                                 f.customer_name,
                                 a.service_date,
                                 a.service_type,
                                 a.service_cost,
                                 a.feedback
                            FROM ss_rpt_service a
                            INNER JOIN ss_mst_car b
                            ON a.car_id=b.car_id
                            INNER JOIN ss_mst_models c
                            ON b.model_id=c.model_id
                            INNER JOIN ss_mst_category d
                            ON c.category_id=d.category_id
                            INNER JOIN ss_trn_employee e
                            ON a.employee_id=e.employee_id
                            INNER JOIN ss_trn_customer f
                            ON a.customer_id=f.customer_id
                            WHERE a.service_id = ? LIMIT 1", $service_id);
    $arrService = $sql->fetchArray();
    $dbcon->close();
    return $arrService;
}


































