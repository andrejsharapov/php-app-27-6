<?php

session_start();

include_once 'database/db.php';

/**
 * @param array $data
 * @return array
 * @throws Exception
 */
function register(array $data): array
{
    return [
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'token' => $data['token'],
        'date' => (new DateTime())->format('Y-m-d')
    ];
}

$user = register($_POST);

//echo '<pre>';
//var_dump($user);
//echo '</pre>';

//
$name = $user['name'];
$email = $user['email'];
$password = $user['password'];
$token = $user['token'];
$date = $user['date'];

//
$query = mysqli_prepare($db_link, "INSERT INTO " . $db_table . " (name, email, password, token, date) " . " VALUES (?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($query, "sssss", $user['name'], $user['email'], $user['password'], $user['token'], $user['date']);
mysqli_stmt_execute($query);
mysqli_stmt_close($query);
mysqli_close($db_link);

header('location: /');
exit();