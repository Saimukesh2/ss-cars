<?php
function getRevenue($arrData)
{
    $employeeName = $arrData['employee_name'];
    $dbcon = new db();
    $query = "SELECT a.revenue_id,
                            b.sale_date,
                            g.category_name, 
                            f.model_name,
                            c.car_name, 
                            c.year,
                            d.employee_name, 
                            e.customer_name, 
                            a.quantity_sold, 
                            c.price, 
                            a.total_sale, 
                            a.discount, 
                            a.net_sale, 
                            a.tax_amount, 
                            a.total_amount_with_tax, 
                            b.payment_method, 
                            a.profit
                            FROM ss_rpt_revenue a
                            INNER JOIN ss_rpt_sales b
                            ON a.sale_id=b.sale_id
                            INNER JOIN ss_mst_car c
                            ON b.car_id=c.car_id
                            INNER JOIN ss_trn_employee d
                            ON b.employee_id=d.employee_id
                            INNER JOIN ss_trn_customer e
                            ON b.customer_id=e.customer_id
                            INNER JOIN ss_mst_models f
                            ON c.model_id=f.model_id
                            INNER JOIN ss_mst_category g
                            ON f.category_id=g.category_id
                            WHERE d.employee_id=?";
    $query .= " ORDER BY b.sale_date DESC, a.revenue_id DESC";
    $sql = $dbcon->query($query, $employeeName);
    $result = $sql->fetchAll();
    $dbcon->close();
    return $result;
}
?>