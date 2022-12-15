<?php

require_once __DIR__ . '/../dotenv.php';

/**
 * @return mysqli
 */
function getDatabase(): mysqli
{
    $db_host     = $_ENV['DB_HOST'];
    $dp_port     = $_ENV['DP_PORT'];
    $db_database = $_ENV['DB_DATABASE'];
    $db_username = $_ENV['DB_USERNAME'];
    $db_password = $_ENV['DB_PASSWORD'];

    return new mysqli($db_host, $db_username, $db_password, $db_database);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Open a connection */
$db_link  = getDatabase() ?? [];
$db_table = 'users';

mysqli_query($db_link, "SET NAMES 'utf8'");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    die();
}
