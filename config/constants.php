<?php
/* DATABSE */

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'camagru');
define('DB_USER', 'root');
define('DB_PASSWORD', 'qweqwe');

/* Email */

define('EMAIL', '');
define('PASSWORD', '');

/* Setup  */

$DB_DSN = 'mysql:host=127.0.0.1;charset=utf8';
$DB_USER = 'root';
$DB_PASSWORD = 'qweqwe';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
?>
