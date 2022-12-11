<?php

/**
 * DATABASE
 */
function getDatabase(): mysqli
{
    $db_host = 'localhost';
    $dp_port = '3306';
    $db_database = 'php_app_27_6';
    $db_username = 'root';
    $db_password = '';

    return new mysqli($db_host, $db_username, $db_password, $db_database);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Open a connection */
$db_link = getDatabase();
$db_table = 'users';

mysqli_query($db_link, "SET NAMES 'utf8'");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$query = "SELECT * FROM " . $db_table;
//$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

//var_dump($result);

//for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

//return $data;