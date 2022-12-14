<?php
session_start();

require_once __DIR__ . '/database/db.php';
require_once __DIR__ . '/vk.php';

if (!isset($_SESSION['token'])) {
    $token = hash('gost-crypto', random_int(0, 999999));
} else {
    $token = $_SESSION['token'];
}

$_SESSION["CSRF"] = $token;

if (isset($_SESSION['user'])) {
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
    <title>Регистрация и вход</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>

<header>
    <ul class="lg:absolute top-0 right-0 left-0 block px-4 py-3 z-10 bg-white">
        <li>
            <?php
            $query = "SELECT * FROM " . $db_table . " ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

            if (!empty($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo 'Новый пользователь: <strong>' . ucfirst($row["name"]) . '</strong>';
                }
            }
            ?>
        </li>
    </ul>
</header>

<main>
    <div class="lg:absolute top-12 right-0 left-0 bg-white mix-blend-screen">
        <div class="text-center text-5xl font-bold pt-3 pb-5 border-y border-2">
            Добро пожаловать
        </div>
    </div>

    <div class="grid lg:grid-cols-2 items-stretch divide-x divide-2 w-full min-h-screen">
        <!-- register -->
        <div class="pb-12 pt-48 px-6 w-full mx-auto">
            <h2 class="text-4xl mb-4">Регистрация</h2>
            <form method="post" action="forms/reg.php" class="mx-auto">
                <div class="w-full inline-flex flex-col gap-y-4">
                    <label>Login
                        <input type="text" name="login" placeholder="Login"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </label>
                    <!--                    <label>Email-->
                    <!--                        <input type="email" name="email" placeholder="Email"-->
                    <!--                               class="mt-2 bg-gray-200 appearance-none border-2 border-green-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500">-->
                    <!--                    </label>-->
                    <label>Password
                        <input type="password" name="password" placeholder="Password"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </label>
                </div>
                <div class="w-full inline-flex justify-between">
                    <input type="submit" value="Регистрация"
                           class="mt-4 cursor-pointer shadow bg-blue-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                    <!-- Выводим на экран ссылку для открытия окна диалога авторизации -->
                    <?php
                    echo $_SESSION['VK'];
                    ?>
                </div>
            </form>

            <?php
            if (!empty($_SESSION['checkReg'])) {
                echo "<div class='mt-5 rounded p-3 border border-$_SESSION[errors]-200 bg-$_SESSION[errors]-50 text-$_SESSION[errors]-600 font-medium'>";
                echo $_SESSION['checkReg'];
                unset($_SESSION['checkReg']);
                echo '</div>';
            }
            ?>
        </div>

        <!-- auth -->
        <div class="pb-12 pt-48 px-6 w-full mx-auto">
            <h2 class="text-4xl mb-4">Вход</h2>
            <form method="post" action="forms/auth.php" class="mx-auto">
                <div class="w-full inline-flex flex-col gap-y-4">
                    <label>Login
                        <input type="text" name="login" placeholder="Login"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </label>
                    <label>Password
                        <input type="password" name="password" placeholder="Password"
                               class="mt-2 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </label>
                    <input type="hidden" name="token" value="<? echo $token; ?>">
                </div>
                <div class="w-full inline-flex justify-between">
                    <input type="submit" value="Вход"
                           class="mt-4 cursor-pointer shadow bg-blue-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    >
                    <!-- Выводим на экран ссылку для открытия окна диалога авторизации -->
                    <?php
                    echo $_SESSION['VK'];
                    ?>
                </div>
            </form>

            <?php
            if (!empty($_SESSION['checkAuth'])) {
                echo "<div class='mt-5 rounded p-3 border border-$_SESSION[errors]-200 bg-$_SESSION[errors]-50 text-$_SESSION[errors]-600 font-medium'>";
                echo $_SESSION['checkAuth'];
                unset($_SESSION['checkAuth']);
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>

<footer class="lg:absolute right-0 bottom-0 left-0 bg-white py-2 border-t border-2">
    <p class="text-center">
        &copy; 2022 by Andrej Sharapov. <a href="https://github.com/andrejsharapov/php-app-27-6" title="GitHub project" target="_blank">GitHub</a>.
    </p>
</footer>

</body>
</html>
