<?php
session_start();

class VkAuth
{
    // app params
    public $appId = 51502000;
    protected $appSecretKey = ''; // TODO: Remove me
    public $redirectUri = 'http://localhost:8080/';

    /**
     * @return string
     */
    function auth(): string
    {
        // build auth link
        $params = [
            'client_id' => $this->appId,
            'client_secret' => $this->appSecretKey,
            'v' => '5.131', // '5.126',
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
            'scope' => 'email',
        ];

        // print(http_build_query($params));
        // die();

        return "https://oauth.vk.com/authorize?" . http_build_query($params);
    }

    /**
     * @param $code
     * @return mixed
     * @throws Exception
     */
    function accessToken($code)
    {
        // get access_token
        $params = [
            'client_id' => $this->appId,
            'client_secret' => $this->appSecretKey,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ];

        // знак (@) позволяет выключить уведомление об ошибке
        $content = @file_get_contents("https://oauth.vk.com/access_token?" . http_build_query($params));

        if (!$content) {
            $error = error_get_last();

            echo 'Errors: ' . $error['message'];
        }

        $response = json_decode($content, true);

        if (isset($response->error)) {
            throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
        }

        return $response;
    }
}

$vk = new VkAuth();

// var_dump($_GET['code']);

if (empty($_GET['code'])) {
//    echo "<a href='" . $vk->auth() . "' class='mt-4 cursor-pointer shadow bg-indigo-700 hover:bg-indigo-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded'>Вход с VK ID</a>";
    $_SESSION['VK'] = "<a href='" . $vk->auth() . "' class='mt-4 cursor-pointer shadow bg-indigo-700 hover:bg-indigo-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded'>Вход с VK ID</a>";
} else {
    $_SESSION['VK'] = "Вы уже авторизованы";

    try {
        $data = $vk->accessToken($_GET['code']);

        $response = $data;
        // var_dump($response);

        $token = $response['access_token'];
        // var_dump($token);

        if (isset($token)) {
            $expiresIn = $response['expires_in']; // token lifetime - 86399 (сутки)
            $userId = $response['user_id'];
            $userEmail = $response['email'];

            // save token
            $_SESSION['token'] = $token;

            // save info as user session
            $_SESSION['user'] = [
                'id' => $userId,
                'email' => $userEmail,
                'role' => 'vk',
            ];

            // var_dump($_SESSION['user']);
        }

    } catch (Exception $e) {
        // $e
        die();
    }
}
