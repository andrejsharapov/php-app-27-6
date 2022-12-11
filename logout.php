<?php

session_start();
unset($_COOKIE['login']);

setcookie('login', null, -1, '/');
unset($_COOKIE['password']);

setcookie('password', null, -1, '/');
session_destroy();

header('location: index.php');
exit();
