<?php 
    require_once 'data/daManageUser.php';
    if(isset($module_code))
    {
        //Query the database to get the user group has got privilege to access this page.
        $count = checkPagePrivilege($module_code);
        if($count == 0)
        {
            //THe user has no privilege to access this page. So redirect to no privilege page.
            header("Location:access_denied.php");
        }
        else
        {
            //The user has got privilege to access this page. So lets load the page.
        }
    }
    else
    {
        // No action as of now
    }

?>