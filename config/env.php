<?php
// Thông tin kết nối DB lấy từ biến môi trường (DB_* hoặc MYSQL* của Railway),
// không có thì dùng mặc định cho XAMPP/Laragon.
if (!function_exists('db_env')) {
    function db_env($names, $default)
    {
        foreach ((array) $names as $name) {
            $value = getenv($name);
            if ($value !== false && $value !== '') {
                return $value;
            }
        }
        return $default;
    }
}

$DB_CONFIG = [
    'host' => db_env(['DB_HOST', 'MYSQLHOST'], 'localhost'),
    'port' => (int) db_env(['DB_PORT', 'MYSQLPORT'], 3306),
    'user' => db_env(['DB_USER', 'MYSQLUSER'], 'root'),
    'pass' => db_env(['DB_PASSWORD', 'MYSQLPASSWORD'], ''),
    'name' => db_env(['DB_NAME', 'MYSQLDATABASE'], 'khachsan_erp'),
];
