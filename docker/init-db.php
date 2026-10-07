<?php
// Imports database/khachsan_erp.sql once, when the target database has no tables yet.
require __DIR__ . '/../config/env.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($DB_CONFIG['host'], $DB_CONFIG['user'], $DB_CONFIG['pass'], $DB_CONFIG['name'], $DB_CONFIG['port']);
$db->set_charset('utf8mb4');

if ($db->query("SHOW TABLES LIKE 'admin'")->num_rows > 0) {
    echo "init-db: tables already exist, nothing to import\n";
    exit(0);
}

$sql = file_get_contents(__DIR__ . '/../database/khachsan_erp.sql');
$db->multi_query($sql);
do {
    if ($result = $db->store_result()) {
        $result->free();
    }
} while ($db->more_results() && $db->next_result());

echo "init-db: imported database/khachsan_erp.sql into {$DB_CONFIG['name']}\n";
