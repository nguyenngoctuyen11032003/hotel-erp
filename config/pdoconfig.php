<?php
require_once(__DIR__ . '/env.php');
$DB_host = $DB_CONFIG['host'];
$DB_user = $DB_CONFIG['user'];
$DB_pass = $DB_CONFIG['pass'];
$DB_name = $DB_CONFIG['name'];
try
{
 $DB_con = new PDO("mysql:host={$DB_host};port={$DB_CONFIG['port']};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 $e->getMessage();
}
