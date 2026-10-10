<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageCustomer.php');

    header('Content-Type: application/json; charset=utf-8');
    $result = array('msg' => 'Failed', 'msg_detail' => 'Invalid request.');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['enc_customerID'])) {
        $enc_customer_id = sanitize_input($_POST['enc_customerID'], 'textarea');
        $customer_id = encrypt_decrypt($enc_customer_id, 'decrypt');

        if (checkCustomerDependencies($customer_id) > 0) {
            $result['msg_detail'] = 'This customer cannot be deleted because sales or service records are linked to it.';
        } else {
            $affectedRows = deleteCustomer($customer_id);
            if ($affectedRows == 1) {
                $result = array('msg' => 'Success', 'msg_detail' => 'Customer deleted successfully.');
            } else {
                $result['msg_detail'] = 'Customer could not be deleted.';
            }
        }
    }

    echo json_encode($result);
?>
