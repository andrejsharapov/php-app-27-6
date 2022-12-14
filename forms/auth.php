<?php
session_start();

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/../database/db.php';

$name = $_POST['login'];
$password = !empty($_POST['password']) ? openssl_digest($_POST['password'], "sha512") : null;
$token = $_POST['token'];

// check token
if ($_POST["token"] == $_SESSION["CSRF"]) {
    // get user info
    $checkUser = "SELECT * FROM " . $db_table . " WHERE `name` = '$name' AND `password` = '$password'";
    $auth = mysqli_query($db_link, $checkUser) or die(mysqli_error($db_link));

    // check user in database
    if (mysqli_num_rows($auth) > 0) {
        $user = mysqli_fetch_assoc($auth);

        // write data to session
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
        $_SESSION['errors'] = 'red';
        $checkUserName = "SELECT * FROM " . $db_table . " WHERE `name` = '$name'";
        $userName = mysqli_query($db_link, $checkUserName) or die(mysqli_error($db_link));

        if (mysqli_num_rows($userName) > 0) {
            $_SESSION['checkAuth'] = 'Введен не правильный пароль.';

            // create new logger
//        $log = new Logger('AUTH LOGGER');

            // set handlers
//        $log->pushHandler(new StreamHandler(__DIR__ . 'auth.log', Logger::INFO));
//        $log->pushHandler(new StreamHandler(__DIR__ . 'warn.log', Logger::WARNING));

            // add records
//        $log->info('Ошибка авторизации', array('user' => $name, 'datetime' => (new DateTime())->format('Y-m-d H:i:s'), 'password' => $password));
            //$log->warning('Предупреждение');
        } else {
            $_SESSION['checkAuth'] = 'Не верный логин или пароль.';
        }

        header('location: /');
    }
}
