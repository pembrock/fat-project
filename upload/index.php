<?php
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Upload");
require "../lib/bootstrap.php";
$result['path_to_root'] = PATH_TO_ROOT;
if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name]))
    header("location: http://fat-project/");
else
    $template = $twig->loadTemplate('upload.html');
$template->display(array('data' => $result));


?>