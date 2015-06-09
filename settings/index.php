<?php
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Settings");
require "../lib/bootstrap.php";

$result['path_to_root'] = PATH_TO_ROOT;
if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name]))
    header("location: http://fat-project/");
else {

    //print_r($_COOKIE);
/*    $_COOKIE['UserEmail'] = "pembrock@gmail.com";
    print_r($_COOKIE);*/
    //echo $auth->getUID($_COOKIE['UserEmail']);
    //$result['email'] = $_COOKIE['UserEmail'];
    $q = $dbh->query("SELECT Name FROM users WHERE ID = " . $auth->getUID($auth->getEmail($_COOKIE['authID'])));
    /*echo $_COOKIE['authID'];
    echo "<br>";
    echo $auth->getEmail($_COOKIE['authID']);*/
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $result['name'] = $row['Name'];
    $result['email'] = $auth->getEmail($_COOKIE['authID']);
    $result['uID'] = $auth->getUID($auth->getEmail($_COOKIE['authID']));
    $template = $twig->loadTemplate('settings.html');

}
$template->display(array('data' => $result));


?>