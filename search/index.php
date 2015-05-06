<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 04.04.2015
 * Time: 13:23
 */
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Поиск");
require PATH_TO_ROOT . "config.php";

$result['path_to_root'] = PATH_TO_ROOT;
$result['page_title'] = PAGE_TITLE;

$t = new DB();
if (isset($_POST['searchObj'], $_POST['city_id'], $_POST['type'], $_POST['typeAuto'])) {
    $coords = array(); $i = 0;
    $object_id = $_POST['type'] == 3 ? "" : " AND Object_id = " . $_POST['type'];
    $car_id = $_POST['typeAuto'] == 5 ? "" : " AND Car_id = " . $_POST['typeAuto'];
    $result = $t->select("SELECT * FROM Objects WHERE City_id = " . $_POST['city_id'] . $object_id . $car_id);
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
$cities_arr = $t->select("SELECT ID, Title FROM Cities");
$result['cities'] = $cities_arr;

//$result['cities'] = $city_str;
$template = $twig->loadTemplate('search.html');
$template->display(array('data' => $result));
//$template->display(array('cities' => $cities_arr));
