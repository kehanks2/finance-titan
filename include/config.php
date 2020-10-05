<?php
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

define('DB_SERVER', 'sql209.epizy.com');
define('DB_USERNAME', 'epiz_26751404');
define('DB_PASSWORD', '1Cm9XygUONbN4sz');
define('DB_DATABASE', 'epiz_26751404_FinanceTitanDB');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
?>