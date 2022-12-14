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
    <div class="lg:absolute top-0 right-0 left-0 flex lg:justify-between px-4 py-3 z-10 bg-white shadow-md">
        <div>
            <?php
            $query = "SELECT * FROM " . $db_table . " ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

            if (!empty($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo 'New user: <strong class="text-gray">' . ucfirst($row["name"]) . '</strong>';
                }
            }
            ?>
        </div>
        <div>
            <a href="https://github.com/andrejsharapov/php-app-27-6"
               title="GitHub project"
               target="_blank"
               class="flex items-center gap-x-2 font-bold"
            >
                <svg style="width: 24px; height: 24px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z"/>
                </svg>
                GitHub
            </a>
        </div>
    </div>
</header>

<main>
    <div class="lg:absolute top-16 right-12 left-12 bg-blue-600 text-white mix-blend-screen rounded-lg overflow-hidden">
        <div class="text-center text-5xl font-extrabold pt-3 pb-5 lg:pl-12">
            Welcome to PHP App 27-6
        </div>
    </div>

    <div class="grid lg:grid-cols-2 items-stretch divide-x divide-2 w-full min-h-screen">
        <!-- register -->
        <div class="pb-12 pt-48 px-6 w-full mx-auto">
            <h2 class="text-4xl mb-6 text-bold">Registration</h2>
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
                           class="mt-4 cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
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
        <div class="pb-12 pt-48 px-6 w-full mx-auto bg-gray-800 text-white transition ease-in-out delay-200 duration-300">
            <h2 class="text-4xl mb-6 text-bold">Sign in</h2>
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
                           class="mt-4 cursor-pointer shadow bg-blue-600 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
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
        &copy; 2022 by Andrej Sharapov.
    </p>
</footer>

</body>
</html>
