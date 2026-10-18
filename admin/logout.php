<?php 
//ob_start();
session_start();
include_once("common/config.php");
include_once("common/dbconn.php");
//require_once('common/common_functions.php');   
//require_once('data/daManageSession.php');  
//deleteSessionData(); 
//Destroy entire session data.
session_destroy();
			
//ob_end_flush();
?>

<?php header('Location: index.php');?>