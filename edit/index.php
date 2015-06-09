<?php
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Edit");
require "../lib/bootstrap.php";
$result['path_to_root'] = PATH_TO_ROOT;
if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name]))
    header("location: http://fat-project/");
else {
    if (isset($_GET['id'])){
        $query = $dbh->query("SELECT f.ID, f.File_name, f.Type_id, f.File_size, f.Date, t.Title AS Type, u.email AS Email, u.Name FROM Files AS f
                              INNER JOIN Type AS t ON t.ID = f.Type_id
                              INNER JOIN users AS u on u.id = f.User_id
                              WHERE f.User_id = " . $auth->getUID($auth->getEmail($_COOKIE['authID'])) ."
                              AND f.ID = " . $_GET['id'] . "
                              ORDER BY f.Date DESC");
        $result['res'] = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $dbh->query("SELECT ID, Title FROM Type");
        $result['type'] = $query->fetchAll(PDO::FETCH_ASSOC);
        $template = $twig->loadTemplate('edit.html');
    }
    else {
        $query = $dbh->query("SELECT f.ID, f.File_name, f.File_size, f.Date, t.Title AS Type, u.email AS Email, u.Name FROM Files AS f
                              INNER JOIN Type AS t ON t.ID = f.Type_id
                              INNER JOIN users AS u on u.id = f.User_id
                              WHERE f.User_id = " . $auth->getUID($auth->getEmail($_COOKIE['authID'])) ."
                              ORDER BY f.Date DESC");
        $result['res'] = $query->fetchAll(PDO::FETCH_ASSOC);
        $template = $twig->loadTemplate('edit_list.html');
    }
}
$template->display(array('data' => $result));

?>