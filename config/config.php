<?php
    require_once(__DIR__ . '/env.php');
    $dbuser=$DB_CONFIG['user'];
    $dbpass=$DB_CONFIG['pass'];
    $host=$DB_CONFIG['host'];
    $db=$DB_CONFIG['name'];
    $mysqli=new mysqli($host,$dbuser, $dbpass, $db, $DB_CONFIG['port']);
