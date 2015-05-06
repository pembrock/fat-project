<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 06.04.2015
 * Time: 11:14
 */
header("Content-type: text/xml");
define("PATH_TO_ROOT", "");
require PATH_TO_ROOT . "config.php";
$t = new DB();
echo '<ymaps xmlns="http://maps.yandex.ru/ymaps/1.x" xmlns:gml="http://www.opengis.net/gml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://maps.yandex.ru/schemas/ymaps/1.x/ymaps.xsd">
    <Representation xmlns="http://maps.yandex.ru/representation/1.x">
        <Style gml:id="agentnedv">
            <iconStyle>
            <href>http://api-maps.yandex.ru/i/0.4/icons/buildings.png</href>
                <size x="27" y="26"/>
                <offset x="-13" y="-13"/>
            </iconStyle>

            <balloonContentStyle>
                <template>#balloonTemplate</template>
            </balloonContentStyle>
        </Style>

        <Template gml:id="balloonTemplate">
            <text><![CDATA[
			<div style="font-size:12px;">
                        <div style="color:#ff0303;font-weight:bold">$[name]</div>
                        <div>Адрес: $[metaDataProperty.AnyMetaData.adres|не задан]</div>
                        <div>Телефон: $[metaDataProperty.AnyMetaData.telefon|не задан]</div>
                    </div>]]></text>
        </Template>
    </Representation>

    <GeoObjectCollection>
        <gml:name>Объекты карте</gml:name>
        <style>#agentnedv</style>
        <gml:featureMembers>';

$result = $t->select("SELECT * FROM Objects");
foreach ($result as $res){


    echo '<GeoObject>';
    echo '<gml:name>', $res['Title'], '</gml:name>';
    echo '<gml:metaDataProperty>';
    echo '<AnyMetaData>';
    echo '<adres>', $res['Address'], '</adres>';
    echo '<telefon>', $res['Phone'], '</telefon>';
    echo '</AnyMetaData>';
    echo '</gml:metaDataProperty>';
    echo '<gml:Point>';
    echo '<gml:pos>', $res['Lat_map'], ' ', $res['Lng_map'], '</gml:pos>';
    echo '</gml:Point>';
    echo '</GeoObject>';

    echo "\n";

}

echo '</gml:featureMembers>
    </GeoObjectCollection>
</ymaps>';

?>
