<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 04.04.2015
 * Time: 14:05
 */
define("PATH_TO_ROOT", "../");
define("PAGE_TITLE", "Регистрация объекта");
require PATH_TO_ROOT . "config.php";
$t = new DB();
$result['path_to_root'] = PATH_TO_ROOT;
$result['page_title'] = PAGE_TITLE;
if (isset($_POST['addObj'], $_POST['title'], $_POST['city'], $_POST['address'], $_POST['tel'], $_POST['email'], $_POST['description'], $_POST['text'], $_POST['type'], $_POST['typeAuto'])){
    $title = addslashes($_POST['title']);
    $city = addslashes($_POST['city']);
    $address = addslashes($_POST['address']);
    $tel = addslashes($_POST['tel']);
    $email = addslashes($_POST['email']);
    $description = addslashes($_POST['description']);
    $text = addslashes($_POST['text']);
    $type = intval($_POST['type']);
    $typeAuto = intval($_POST['typeAuto']);

    //получаем координаты адреса
    $coordinates = getCoordinates($city . ', ' . $address);
    if ($coordinates != 'error') { //если получили
        $coord = explode(' ', $coordinates);
        $Lat_map = $coord[0];
        $Lng_map = $coord[1];
        $cnt = $t->count("Cities", "Title = '{$city}'"); //проверяем город на наличие в базе
        if ($cnt > 0){
            $result = $t->select("SELECT ID FROM Cities WHERE Title = '" . $city . "' LIMIT 1");
            foreach($result as $res)
                $city_id = $res['ID'];
        }
        else{//иначе добавляем в базу
            $into = array(
                "Title" =>  $city
            );
            $city_id = $t->insert("Cities", $into);
        }

        $into = array(
            "User_id"   =>  $_SESSION['UserID'],
            "Title"     =>  $title,
            "City_id"   =>  $city_id,
            "Address"   =>  $address,
            "Phone"     => $tel,
            "Email"     =>  $email,
            "Description"   =>  $description,
            "Text"      =>  $text,
            "Object_id" =>  $type,
            "Car_id"    =>  $typeAuto,
            "Lat_map"   =>  $Lat_map,
            "Lng_map"   =>  $Lng_map
        );
        $t->insert("Objects", $into);
        echo "ok";
    }
    else
        echo "Не удалось определить координаты по указанному адресу";

    exit;
}


if (isset($_SESSION['UserID'])) {
    $template = $twig->loadTemplate('add.html');
    $template->display(array('data' => $result));
}
else
    header('location: /reg/');



/********** Получаем координаты по адресу ***********/
function getCoordinates($path){
    $params = array(
        'geocode' => $path, // адрес
        'format'  => 'json',                          // формат ответа
        'results' => 1,                               // количество выводимых результатов
        //'key'     => '...',                           // ваш api key
    );
    $response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($params, '', '&')));

    if ($response->response->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found > 0)
    {
        return $response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
    }
    else
    {
        return 'error';
    }
}