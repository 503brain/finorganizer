<?php
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'finorganizer');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connection) {
    die("Conexão não realizada com o banco de dados: " . mysqli_connect_error());
}

mysqli_set_charset($connection, 'utf8');
?>