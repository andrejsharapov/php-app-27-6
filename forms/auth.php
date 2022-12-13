<?php
session_start();

require_once __DIR__ . '/../database/db.php';

$name = $_POST['login'];
$password = openssl_digest($_POST['password'], "sha512");
$token = $_POST['token'];

if ($_POST["token"] == $_SESSION["CSRF"]) {
    // get user info
    $findUserName = "SELECT * FROM " . $db_table . " WHERE `name` = '$name' AND `password` = '$password'";
    $auth = mysqli_query($db_link, $findUserName) or die(mysqli_error($db_link));

    if (mysqli_num_rows($auth) > 0) {
        $user = mysqli_fetch_assoc($auth);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => openssl_digest($user['password'], "sha512"),
            'date' => $user['date'],
            'role' => $user['role'],
        ];

        $_SESSION['checkAuth'] = 'Авторизация прошла успешно.';
        header('location: /hello.php');

    } else {
        $_SESSION['checkAuth'] = 'Не верный логин или пароль.';
        header('location: /');
    }
}
