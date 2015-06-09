<?php
session_start();
include("lib/Auth/languages/en.php");
include("lib/Auth/config.class.php");
include("lib/Auth/auth.class.php");

$dbh = new PDO("mysql:host=localhost;dbname=fatproject", "root", "");

$config = new Config($dbh);
$auth = new Auth($dbh, $config, $lang);
//echo $config->cookie_name;
//exit;
/*if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name])) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";
    echo "<br>You need log in!";
    exit();
}
else{
    echo "Everything is allright!";
}*/
//$reg = $auth->register("pembrock1@gmail.com", "123123Ff#", "123123Ff#");
//$reg = $auth->activate("6fE63L45hM4H4TZ4MI0V");
/*echo "<pre>";
print_r($reg);
echo "</pre>";*/
//$reg = $auth->login("pembrock@gmail.com", "123123Ff#", 1);
/*if (empty($reg['error'])) {
    //setcookie('authID', $reg['hash'], time() + 60*60*24*30, '/', '.' . $_SERVER['HTTP_HOST']);
    setcookie('authID', $reg['hash']);
    echo "ok";
}
else
    echo "error";*/
/*$_SESSION['user'] = $reg['hash'];
$_COOKIE['user'] = $reg['hash'];*/
/*echo "<pre>";
print_r($reg);
print_r($_SESSION);
print_r($_COOKIE);
echo "</pre>";*/
/*$reg = $auth->logout("766a69a762fb8954164223474e863ba50c87df4c");
print_r($reg);*/
//$_SESSION['user_auth'] = "123";
//echo $_SESSION['user_auth'];
//setcookie("user", "test");
//unset($_COOKIE["user"]);

print_r($_COOKIE);
$auth->logout($_COOKIE[$config->cookie_name]);
print_r($_COOKIE);
?>