<?php
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Queries");
require "../lib/bootstrap.php";
$result['path_to_root'] = PATH_TO_ROOT;
if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name]))
    header("location: http://fat-project/");
else {
        $query = $dbh->query("SELECT ID, Query FROM Queries
                              WHERE User_id = " . $auth->getUID($auth->getEmail($_COOKIE['authID'])) ."
                              ORDER BY ID DESC");
        $result['res'] = $query->fetchAll(PDO::FETCH_ASSOC);
        $template = $twig->loadTemplate('queries_list.html');

}
$template->display(array('data' => $result));

?>