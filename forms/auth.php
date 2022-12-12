<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;

session_start();

require_once '../database/db.php';

$name = $_POST['login'];
$password = openssl_digest($_POST['password'], "sha512");
$token = $_POST['token'];

// Создаем логгер
$log = new Logger('mylogger');

// Хендлер, который будет писать логи в "mylog.log" и слушать все ошибки с уровнем "WARNING" и выше .
$log->pushHandler(new StreamHandler('mylog.log', Logger::WARNING));

// Хендлер, который будет писать логи в "troubles.log" и реагировать на ошибки с уровнем "ALERT" и выше.
$log->pushHandler(new StreamHandler('troubles.log', Logger::ALERT));


// Добавляем записи
$log->warning('Предупреждение');
$log->error('Большая ошибка');
$log->info('Просто тест');

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
        ];

        $_SESSION['checkAuth'] = 'Авторизация прошла успешно.';
        header('location: /hello.php');

    } else {
        $_SESSION['checkAuth'] = 'Не верный логин или пароль.';
        header('location: /');
    }
}
?>

<pre>
    <?php
//        print_r($auth);
//        print_r($user);
    ?>
</pre>