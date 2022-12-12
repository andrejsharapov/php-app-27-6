<?php
session_start();

unset($_SESSION['user']);
//unset($_COOKIE['user']);
//setcookie('user', null, -1, '/');

header('location: /');
exit();
