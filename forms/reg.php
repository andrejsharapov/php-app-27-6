<?php
session_start();

require_once __DIR__ . '/../database/db.php';

/**
 * @param array $data
 * @return array
 */
function register(array $data): array
{
    return [
        'name'     => $data['login'] ?? null,
        'email'    => $data['email'] ?? '',
        'password' => openssl_digest($data['password'], "sha512") ?? null,
        'date'     => (new DateTime())->format('Y-m-d H:i:s') ?? null,
    ];
}

//get user info
$user = register($_POST);

// var_dump($user);

if (empty($_POST['login']) || empty($_POST['password'])) {
    $_SESSION['errors'] = 'red';
}

if (empty($_POST['login'])) {
    $_SESSION['checkReg'] = 'Придумайте логин для входа.';
}

if (empty($_POST['password'])) {
    $_SESSION['checkReg'] = 'Заполните поле для ввода пароля.';
}

if (!empty($_POST['login']) && !empty($_POST['password'])) {
  unset($_SESSION['errors']);

// check login in database
$findUserName = "SELECT * FROM `users` WHERE name = '$user[name]'";
$result = mysqli_query($db_link, $findUserName) or die(mysqli_error($db_link));
$rows = mysqli_num_rows($result) > 0;

if ($rows) {
    $_SESSION['checkReg'] = 'Пользователь с таким логином уже существует.';
    $_SESSION['errors'] = 'blue';
} else {
    $query = mysqli_prepare($db_link, "INSERT INTO " . $db_table . " (name, email, password, date) " . " VALUES (?, ?, ?, ?)");

    mysqli_stmt_bind_param($query, "ssss", $user['name'], $user['email'], $user['password'], $user['date']);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);
    mysqli_close($db_link);

    if ($query) {
        $_SESSION['checkReg'] = 'Вы успешно зарегистрированы!';
        $_SESSION['errors']   = 'green';
    }
  }
}

header('location: /');
