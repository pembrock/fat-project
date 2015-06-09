<?php
define("PATH_TO_ROOT", "");
define("PAGE_TITLE", "Главная");
require "lib/bootstrap.php";

if (isset($_GET['act'], $_GET['rkey'])){
    $reg = $auth->activate($_GET['rkey']);
    if (empty($reg['error']))
        $template = $twig->loadTemplate('activation.html');
    else
        $template = $twig->loadTemplate('error.html');
    $template->display(array());
    exit;
}

//$auth->logout($_COOKIE[$config->cookie_name]);
if(!isset($_COOKIE[$config->cookie_name]) || !$auth->checkSession($_COOKIE[$config->cookie_name]))
    $template = $twig->loadTemplate('startpage.html');
else {
    //print_r($_COOKIE);
    if (isset($_GET['s']))
        $query = $dbh->query("SELECT f.ID, f.File_name, f.File_size, f.Date, t.Title AS Type, u.email AS Email, u.Name FROM Files AS f
                              INNER JOIN Type AS t ON t.ID = f.Type_id
                              INNER JOIN users AS u on u.id = f.User_id
                              WHERE File_name LIKE \"%" . $_GET['s'] . "%\"");
    else if($_GET['search']){
        $query_string = "f.Type_id = " . $_GET['type'] . (isset($_GET['date']) ? (" AND f.Date >=\"" . $_GET['date'] . " 00:00:00\" AND f.Date <=\"" . $_GET['date'] . " 23:59:59\"") : "");
        $orderBy = " ORDER BY f." . $_GET['sort'];

        $query = $dbh->query("SELECT f.ID, f.File_name, f.File_size, f.Date, t.Title AS Type, u.email AS Email, u.Name FROM Files AS f
                              INNER JOIN Type AS t ON t.ID = f.Type_id
                              INNER JOIN users AS u on u.id = f.User_id
                              WHERE " . $query_string . $orderBy);
    }
    else
        $query = $dbh->query("SELECT f.ID, f.File_name, f.File_size, f.Date, t.Title AS Type, u.email AS Email, u.Name FROM Files AS f
                              INNER JOIN Type AS t ON t.ID = f.Type_id
                              INNER JOIN users AS u on u.id = f.User_id
                              ORDER BY f.Date DESC");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_COOKIE['view'])){
        if($_COOKIE['view'] == 'table')
            $template = $twig->loadTemplate('index_table.html');
        else
            $template = $twig->loadTemplate('index.html');
    }
    else
        $template = $twig->loadTemplate('index.html');

}
$template->display(array('data' => $result));


?>