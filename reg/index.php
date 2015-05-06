<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 05.04.2015
 * Time: 12:35
 */
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Регистрация");
require PATH_TO_ROOT . "config.php";
$result['path_to_root'] = PATH_TO_ROOT;
$result['page_title'] = PAGE_TITLE;
$t = new DB();
//print_r($_SESSION);
if (isset($_POST['reg'], $_POST['login'], $_POST['pass'])){
    $cnt = $t->count("Users", "Login = {$_POST['pass']}");
    if ($cnt > 0){
        echo "Пользователь с таким логином уже существует";
    }
    else{
        $into = array(
            "Login" => $_POST['login'],
            "Password"  => md5($_POST['pass'])
        );
        $lastid = $t->insert("Users", $into);
        $_SESSION['UserID'] = $lastid;
        echo "ok";
    }
    exit;
}
if (!isset($_SESSION['UserID'])) {
    $template = $twig->loadTemplate('reg.html');
    $template->display(array('data' => $result));
}
else{
    header('location: /add/');
}
