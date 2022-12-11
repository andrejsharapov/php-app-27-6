<?php

session_start();

include_once 'database/db.php';

$query = "SELECT * FROM " . $db_table . " ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

//var_dump($_SESSION['auth']);

if (isset($_SESSION['auth'])) {
    header('location: /hello.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>

<header>
    <ul class="lg:absolute top-0 right-0 left-0 block px-4 py-3 z-10 bg-white">
        <li>Новый пользователь:
            <?php
            if (!empty($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo ucfirst($row["name"]);
                }
            }
            ?>
        </li>
    </ul>
</header>

<main class="grid min-h-screen">
    <div class="lg:absolute top-12 right-0 left-0 bg-white mix-blend-screen">
        <div class="text-center text-5xl font-bold pt-3 pb-5 border-y border-2">
            Добро пожаловать
        </div>
    </div>

    <div class="grid lg:grid-cols-2">
        <!-- register -->
        <div class="py-12 grid place-content-center h-full hover:bg-green-500 hover:text-white transition ease-in-out delay-200 duration-300">
            <h2 class="text-4xl mb-4">Регистрация</h2>
            <form method="post" action="reg.php" class="max-w-lg mx-auto">
                <div class="w-full inline-flex flex-col gap-y-4">
                    <label>Login
                        <input type="text" name="name" placeholder="Login"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-green-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                    </label>
                    <label>Email
                        <input type="email" name="email" placeholder="Email"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-green-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                    </label>
                    <label>Password
                        <input type="password" name="password" placeholder="Password"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-green-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                    </label>
                    <input type="hidden" name="token" value="<? $token ?>">
                </div>
                <div class="w-full inline-flex justify-between">
                    <input type="submit" value="Регистрация"
                           class="mt-4 cursor-pointer shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    <button type="button"
                            class="mt-4 cursor-pointer shadow bg-indigo-700 hover:bg-indigo-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Авторизоваться через VK
                    </button>
                </div>
            </form>
        </div>

        <!-- login -->
        <div class="py-12 grid place-content-center h-full hover:bg-blue-500 hover:text-white transition ease-in-out delay-200 duration-300">
            <?php

            $token = hash('gost-crypto', random_int(0, 999999));
            $_SESSION["CSRF"] = $token;

            var_dump($token);
            ?>

            <h2 class="text-4xl mb-4 mt-2">Вход</h2>
            <form method="post" action="auth.php" class="mb-24 max-w-lg mx-auto">
                <div class="w-full inline-flex flex-col gap-y-4">
                    <label>Login
                        <input type="text" name="name" placeholder="Login"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-blue-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    </label>
                    <label>Password
                        <input type="password" name="password" placeholder="Password"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-blue-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    </label>
                </div>
                <input type="hidden" name="token" value="<? $token ?>">
                <div class="w-full inline-flex justify-between">
                    <input type="submit" value="Войти"
                           class="mt-4 cursor-pointer shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    <button type="button"
                            class="mt-4 cursor-pointer shadow bg-indigo-700 hover:bg-indigo-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Авторизоваться через VK
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<footer class="lg:absolute right-0 bottom-0 left-0 bg-white py-2 border-t border-2">
    <p class="text-center">
        &copy; 2022
    </p>
</footer>
</body>

</html>
