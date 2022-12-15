<?php
session_start();

$user = $_SESSION['user'];

if (!$user) {
    header('location: /');
}

$page = array(
  'title' => 'Hello, ' . ucfirst($user['name'] ?? "vk user №" . $user['id'])
);
?>

<?php include 'layouts/components/header.php'; ?>

<main class="w-full h-full flex items-center flex-grow">
    <div class="w-2/3 mx-auto py-6">
        <!-- Show if VK -->
        <?php if ($user['role'] === 'vk'): ?>
            <div class="rounded overflow-hidden">
                <img src="src/hello.svg" class="hidden lg:block w-full max-w-lg mx-auto" alt="hello">
            </div>
        <?php endif; ?>

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
    </div>
</main>

<?php include 'layouts/components/footer.php'; ?>
