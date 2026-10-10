<?php
    require_once('../common/config.php');
    require_once('../common/dbconn.php');
    require_once('../common/common_functions.php');
    require_once('../data/daManageEnquiry.php');

    $input = $_GET['term']; // 'term' is the default parameter name used by jQuery UI Autocomplete
    if(isset($_GET['mode']))
    {
        $mode=$_GET['mode'];
    }
    else $mode = 'not new';

    $matchingCustomers = getCustomerNames($input, $mode );

    echo json_encode($matchingCustomers);
    ?>