<?php
session_start();

// Параметры приложения
$clientId     = '51502000';
$clientSecret = '';
$redirectUri  = 'http://localhost:8080/';

// Формируем ссылку для авторизации
$params = array(
    'client_id'     => $clientId,
    'redirect_uri'  => $redirectUri,
    'response_type' => 'code',
    'v'             => '5.131',
    'scope'         => 'photos',
);

if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
    $error = error_get_last();
    throw new Exception('HTTP request failed. Error: ' . $error['message']);
}

$response = json_decode($content);

// Если при получении токена произошла ошибка
if (isset($response->error)) {
    throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
}
//А вот здесь выполняем код, если все прошло хорошо
$token = $response->access_token; // Токен
$expiresIn = $response->expires_in; // Время жизни токена
$userId = $response->user_id; // ID авторизовавшегося пользователя

// Сохраняем токен в сессии
$_SESSION['token'] = $token;
