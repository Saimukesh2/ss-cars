<?php
function insertSales($arrData)
{
    $carName = $arrData['car_name'];
    $employeeName = $arrData['employee_name'];
    $customerName = $arrData['customer_name'];
    $saledate = $arrData['sale_date'];
    $paymentmethod = $arrData['payment_method'];
    $dbcon = new db();
    $sql = $dbcon->query("INSERT INTO `ss_rpt_sales` 
                                (     `car_id`,
                                      `employee_id`,
                                      `customer_id`,
                                      `sale_date` ,
                                      `payment_method`
                                )
                                    VALUES (?, ?, ?, ?, ?)",
                                    $carName,
                                    $employeeName,
                                    $customerName,
                                    $saledate,
                                    $paymentmethod);
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
    }

function deleteSales()
{

}
function getAllSales()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT a.sale_id,
                                 d.category_name,
                                 c.model_name,
                                 b.car_name,
                                 b.year,
                                 e.employee_name,
                                 f.customer_name,
                                 a.sale_date,
                                 b.price,
                                 a.payment_method
                            FROM ss_rpt_sales a
                            INNER JOIN ss_mst_car b
                            ON a.car_id=b.car_id
                            INNER JOIN ss_mst_models c
                            ON b.model_id=c.model_id
                            INNER JOIN ss_mst_category d
                            ON c.category_id=d.category_id
                            INNER JOIN ss_trn_employee e
                            ON a.employee_id=e.employee_id
                            INNER JOIN ss_trn_customer f
                            ON a.customer_id=f.customer_id');
    $arrSales = $sql->fetchAll();
    $dbcon->close();
    return $arrSales;
}

function getSalesById($sale_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.sale_id,
                                 b.car_id,
                                 e.employee_id,
                                 f.customer_id,
                                 c.model_id,
                                 d.category_id,
                                 d.category_name,
                                 c.model_name,
                                 b.car_name,
                                 b.year,
                                 e.employee_name,
                                 f.customer_name,
                                 a.sale_date,
                                 b.price AS sale_price,
                                 a.payment_method
                            FROM ss_rpt_sales a
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
                            WHERE a.sale_id = ? LIMIT 1", $sale_id);
    $arrSales = $sql->fetchArray();
    $dbcon->close();
    return $arrSales;
}

function updateSales($arrData)
{
    $carName = $arrData['car_name'];
    $saledate = $arrData['sale_date'];
    $paymentmethod = $arrData['payment_method'];
    $sale_id = $arrData['sale_id'];

    // Open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("UPDATE `ss_rpt_sales` 
                          SET `car_id` = ?, 
                              `sale_date` = ?,
                              `payment_method` = ? 
                          WHERE `sale_id` = ?",
                          $carName,    
                          $saledate,
                          $paymentmethod,
                          $sale_id
                        );

    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}





















?>