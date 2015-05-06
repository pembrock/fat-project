<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 04.04.2015
 * Time: 14:05
 */
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Редактирование объекта");
require PATH_TO_ROOT . "config.php";
$t = new DB();
$result['path_to_root'] = PATH_TO_ROOT;
$result['page_title'] = PAGE_TITLE;
if (isset($_GET['id'], $_SESSION['UserID'])){
    $res = $t->select("SELECT * FROM Objects WHERE ID = " . intval($_GET['id']) . " AND User_id = " . $_SESSION['UserID']);
    $result['object'] = $res;
    $template = $twig->loadTemplate('edit.html');
    $template->display(array('data' => $result));
}
else if($_SESSION['UserID'])
{
    $res = $t->select("SELECT ID, Title FROM Objects WHERE User_id = " . $_SESSION['UserID']);
    $result['objects'] = $res;
    $template = $twig->loadTemplate('edit_list.html');
    $template->display(array('data' => $result));
}