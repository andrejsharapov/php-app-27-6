<?php

include_once 'database/db.php';

$query = "SELECT * FROM " . $db_table;
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

$users = $data;

//
$username = $_POST['name'] ?? null;
$password = $_POST['password'] ?? null;

$user = array_filter($users, function ($user) use ($username) {
//    print_r($user);
    return $user['name'] == $username;
});

//print_r($user);

foreach ($user as $key => $val) {
    $user = [
        $val['name'] => [
            'id' => $val['id'],
            'password' => $val['password']
        ]
    ];
}

//var_dump($_POST["token"]);
//var_dump($_SESSION["CSRF"]);
//
//if($_POST["token"] == $_SESSION["CSRF"])
//{
//    echo '123';
//}

//print_r($user);

/**
 * @param string $name
 * @return bool
 */
function existsUser(string $name): bool
{
    $new_arr = $GLOBALS['user'];
    $key = array_key_exists($name, $new_arr);

    if (!$key) {
        echo 'Пользователь не найден';

        return false;
    } else {
        echo 'Пользователь соответствует базе данных';

        return true;
    }
}

/**
 * @param string $name
 * @param string $password
 * @return bool|null
 */
function checkPassword(string $name, string $password): ?bool
{
    $users = $GLOBALS['user'];

//    var_dump($users);

    foreach ($users as $key => $val) {
//        var_dump($val);

        // проверка, совпадает ли логин с данными из бд
        if ($key === $name) {
            $pass = $val['password'];

            // проверка, совпадает ли пароль с данными из бд
            if ($password === $pass) {
                setcookie('name', $name, 0, '/');
                setcookie('password', openssl_digest($pass, "sha512"), 0, '/');

                return true;
            } else {
                echo 'Неправильное имя пользователя или пароль';
                return false;
            }
        } else {
            // если возникла ошибка
            return existsUser($name);
        }
    }

    return null;
}

/**
 * @return void
 */
function getCurrentUser()
{
    $username = $_POST['name'] ?? null;
    $password = $_POST['password'] ?? null;

    if (null !== $username || null !== $password) {
        if (checkPassword($username, $password)) {

            session_start();

            $users = $GLOBALS['users'];

            if (array_key_exists($username, $users)) {
                $user_id = $users[$username]['id'];
            }

            $_SESSION['auth'] = true;
            $_SESSION['id'] = $user_id ?? 'Id not found';
            $_SESSION['name'] = $username;
        }

        $auth = $_SESSION['auth'] ?? null;

//        if (!$auth) {
//            $redirect = '/';
//        } else {
//            $redirect = 'hello.php';
//        }
//
//        header('location: ' . $redirect);
//        exit;
    }
}

getCurrentUser();