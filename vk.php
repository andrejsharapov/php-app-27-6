<?php
session_start();

require_once __DIR__ . '/dotenv.php';

class VkAuth
{
    // app params
    public $appId;
    protected $appSecretKey;
    public $redirectUri;

    public function __construct()
    {
        $this->appId        = $_ENV['APP_ID'];
        $this->appSecretKey = $_ENV['APP_SECRET_KEY'];
        $this->redirectUri  = $_ENV['REDIRECT_URI'];
    }

    /**
     * @return string
     */
    public function auth(): string
    {
        // build auth link
        $params = [
            'client_id'     => $this->appId,
            'client_secret' => $this->appSecretKey,
            'v'             => '5.131',
            'response_type' => 'code',
            'redirect_uri'  => $this->redirectUri,
            'scope'         => 'email',
        ];

        return "https://oauth.vk.com/authorize?" . http_build_query($params);
    }

    /**
     * @param $code
     * @return mixed
     * @throws Exception
     */
    public function accessToken($code)
    {
        // get access_token
        $params = [
            'client_id'     => $this->appId,
            'client_secret' => $this->appSecretKey,
            'redirect_uri'  => $this->redirectUri,
            'code'          => $code,
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

if (empty($_GET['code'])) {
    $_SESSION['VK'] = "<a href='" . $vk->auth() . "' class='mt-4 cursor-pointer shadow bg-indigo-700 hover:bg-indigo-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded'>Вход с VK ID</a>";
} else {
    $_SESSION['VK'] = "Вы уже авторизованы";

    try {
        $data     = $vk->accessToken($_GET['code']);
        $response = $data;
        $token    = $response['access_token'];

        if (isset($token)) {
            $expiresIn = $response['expires_in']; // token lifetime - 86399 (сутки)
            $userId    = $response['user_id'];
            $userEmail = $response['email'];

            // save token
            $_SESSION['token'] = $token;

            // save info as user session
            $_SESSION['user'] = [
                'id'    => $userId,
                'email' => $userEmail,
                'role'  => 'vk',
            ];
        }

    } catch (Exception $e) {
        // $e
        die();
    }
}
