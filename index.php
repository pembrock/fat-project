<?php
define("PATH_TO_ROOT", "");
define("PAGE_TITLE", "Главная");
require PATH_TO_ROOT . "config.php";


$t = new DB();

if (isset($_GET['logout'])){
    unset($_SESSION['UserID']);
}

if (isset($_POST['log'], $_POST['login'], $_POST['password'])){
    $cnt = $t->count("Users", "Login = '{$_POST['login']}' AND Password = '" . md5($_POST['password']) . "'"); //проверяем город на наличие в базе
    if ($cnt > 0){
        $res = $t->select("SELECT ID FROM Users WHERE Login = '" . $_POST['login'] . "' AND Password = '" . md5($_POST['password']) . "'");
        foreach($res as $r)
            $_SESSION['UserID'] = $r["ID"];
        header('location: /');
    }
}


if (isset($_POST['getCoords'])) {
   $coords = array(); $i = 0;
   $result = $t->select("SELECT * FROM Objects");
    $str = '{"type": "FeatureCollection", "features": [';
    foreach ($result as $res)
       {

      $coords[] =  '{"type": "Feature", "id": '. $res['ID'] .', "geometry": {"type": "Point", "coordinates": ['.$res['Lng_map'].', '.$res['Lat_map'].']}, "properties": {"balloonContent": "'.$res['Title'].'<br><br> ' .$res['Address']. '<br>'. $res['Phone'] .'<br><br>' .$res['Description']. '", "clusterCaption": "Еще одна метка", "hintContent": "'.$res['Title'].'"}}';


    }

    $str .= implode(', ', $coords);
    $str .= ']}';
    echo $str;
    exit;
}

//$result = $t->select("SELECT Name, Comment, Date, Time FROM comment ORDER BY ID DESC");
//print_r($_SESSION);
$result['path_to_root'] = PATH_TO_ROOT;
$result['page_title'] = PAGE_TITLE;
if (isset($_SESSION['UserID'])) {
    $user = $t->select("SELECT Login FROM Users WHERE ID = " . $_SESSION['UserID']);
    foreach($user as $u)
        $result['username'] = $u['Login'];
}
$template = $twig->loadTemplate('index.html');
$template->display(array('data' => $result));

?>