<?php
require_once('../common/config.php');
require_once('../common/dbconn.php');
require_once('../common/common_functions.php');
require_once('../data/daManageService.php');

header('Content-Type: application/json; charset=utf-8');
$result = array('msg' => 'Failed', 'msg_detail' => 'Invalid request.');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['enc_serviceID'])) {
    $encServiceId = sanitize_input($_POST['enc_serviceID'], 'textarea');
    $serviceId = encrypt_decrypt($encServiceId, 'decrypt');
    if ($serviceId !== false && ctype_digit((string)$serviceId)) {
        $affectedRows = deleteService($serviceId);
        if ($affectedRows === 1 || $affectedRows === '1') {
            $result = array('msg' => 'Success', 'msg_detail' => 'Service record deleted successfully.');
        } else {
            $result['msg_detail'] = 'Service record could not be deleted.';
        }
    }
}

echo json_encode($result);
?>
