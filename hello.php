<?php
session_start();

if (!$_SESSION['user']) {
    header('location: /');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello, <?php echo ucfirst($_SESSION['name']) ?>!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="m-0 min-h-screen flex flex-col dark:bg-gray-800 dark:text-gray-300">

<header class="p-4 flex justify-between bg-blue-500 sticky top-0 z-10">
    <div class="text-xl uppercase font-bold text-white">PHP-APP-27-6</div>
    <ul class="flex gap-4">
        <?php if (isset($_SESSION['user'])): ?>
            <li>
                <a href="forms/logout.php" class="rounded px-2 py-1 text-white uppercase">Выход</a>
            </li>
        <?php endif; ?>
    </ul>
</header>

<main class="w-full h-full flex items-center flex-grow">
    <div class="w-2/3 mx-auto py-6">
        <!-- View All -->
        <p class="mb-4">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias consequuntur corporis dolorem
            dolores eligendi esse eveniet ex, in minima nihil, officia officiis optio recusandae repellendus sapiente
            similique, vitae. Suscipit. Alias amet debitis dicta dignissimos dolorem doloremque ea earum eveniet
            expedita facilis fugiat ipsa iure
            iusto minus molestiae molestias optio perferendis porro quidem repellendus sit, sunt tempore tenetur ullam
            vitae. Accusantium architecto explicabo harum labore numquam tempora unde. Adipisci delectus dolor eius eum
            expedita, harum illum ipsam libero maxime, modi obcaecati placeat provident, quaerat quas ratione sit
            voluptate voluptatem? Doloribus! Alias aliquam blanditiis cum earum eum ex excepturi, hic iste iure magnam
            minima molestias nemo nostrum
            officia officiis omnis perferendis porro repellat soluta temporibus unde, velit voluptate! Quos soluta,
            sunt?
        </p>
        <!-- Show if VK -->
        <div class="rounded overflow-hidden">
            <img src="https://picsum.photos/1600/400?random" alt="">
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
