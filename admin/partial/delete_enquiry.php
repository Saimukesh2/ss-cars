<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageEnquiry.php');

    header('Content-Type: application/json; charset=utf-8');
    $result = array('msg' => 'Failed', 'msg_detail' => 'Invalid request.');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['enc_enquiryID'])) {
        $enc_enquiry_id = sanitize_input($_POST['enc_enquiryID'], 'textarea');
        $enquiry_id = encrypt_decrypt($enc_enquiry_id, 'decrypt');

        $affectedRows = deleteEnquiry($enquiry_id);
        if ($affectedRows == 1) {
            $result = array('msg' => 'Success', 'msg_detail' => 'Enquiry deleted successfully.');
        } else {
            $result['msg_detail'] = 'Enquiry could not be deleted.';
        }
    }

    echo json_encode($result);
?>
