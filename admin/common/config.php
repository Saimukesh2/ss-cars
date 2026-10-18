<?php 
// DECLARATION OF CONSTANTS FOR DB 
define('DB_HOST','localhost:3306');
              //define('DB_PORT','3307');
define('DB_USER','root');
define('DB_PASSWORD','DefiantWhale');
define('DB_NAME','ss-cars');
define('ERROR_LOG_PATH','common/exceptions.txt');
date_default_timezone_set("Asia/Kolkata");
define('SESSION_TIMEOUT','30');//30 Minutes

//Security
define('ENCRYPT_METHOD','AES-256-CBC');
define('SECRET_KEY','2SJC6OKPF8K0QRB'); // user define private key
define('SECRET_IV','1bcG9KJ7u99'); // user define secret key

//define('FILE_DOWNLOAD_PATH', WEBROOT.'cron_jobs/temp_files/');
//print(FILE_DOWNLOAD_PATH);
//define('FORM_UPLOAD_PATH', WEBROOT.'uploads/');
//define('ERROR_LOG_PATH',WEBROOT.'logs/exception.txt');
//define('IMG_URL',DOMAINURL.'img/');
//define('UNIV_TERMS_CONDITIONS',DOMAINURL.'terms_conditions/');
//define('SESSION_TIMEOUT','30');
//define('DOCUMENT_UPLOAD_PATH',WEBROOT.'uploads/');
define('MYSQL_TZ','+05:30');
define('ENVIRONMENT','local');
define('HTTP_CONFIG','http://');
define('HTTP_PATH', HTTP_CONFIG. $_SERVER['HTTP_HOST']);
define('CGST','9');
define('SGST','9');
define('GST_IN','18');

//DEDBUGGIN - on
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Session
//DEDBUGGIN - on
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$allowd_file_size   = "31457280"; //30 MB allowed Size

//dates
$short_date         = gmdate('Ymd'); //short date
$iso_date           = gmdate("Ymd\THis\Z"); //iso format date
$expiration_date    = gmdate('Y-m-d\TG:i:s\Z', strtotime('+1 hours')); 




// Continue with other configuration settings or functions in your config.php file...

?>