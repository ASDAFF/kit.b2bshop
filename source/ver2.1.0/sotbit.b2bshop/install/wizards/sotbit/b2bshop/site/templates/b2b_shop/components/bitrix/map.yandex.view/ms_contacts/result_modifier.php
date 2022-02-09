<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arSelect = Array('ID', 'PROPERTY_'.$arParams["MAP_PROPERTY_PLACEMARKS"], 'PROPERTY_'.$arParams["MAP_PROPERTY_ICON"], 'PROPERTY_'.$arParams["MAP_PROPERTY_TITLE"], 'PROPERTY_'.$arParams["MAP_PROPERTY_TEXT"]);
$arFilter_point = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID_PLACEMARKS'], 'ACTIVE'=>'Y');
$points= CIBlockElement::GetList(array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"], $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"]), $arFilter_point, false, false, $arSelect);

while($ob = $points->GetNextElement())
{
 $arPoint[] = $ob->GetFields();
                                                            
}

foreach($arPoint as $key => $item) {
        $arItemPoint = explode(',', $item['PROPERTY_'.$arParams["MAP_PROPERTY_PLACEMARKS"].'_VALUE']);
        $arResult['POSITION']['PLACEMARKS'][] = array(
        'ID' => $arParams['~MAP_ID'].'_'.$item['ID'],
        'LAT' => $arItemPoint[0],
        'LON' => $arItemPoint[1],
        'TEXT' => "<p class='yandex_map_title'>".$item['PROPERTY_'.$arParams["MAP_PROPERTY_TITLE"].'_VALUE']."</p>"."<p class='yandex_map_text'>".$item['PROPERTY_'.$arParams["MAP_PROPERTY_TEXT"].'_VALUE']."</p>",
        'ICON' => $item['PROPERTY_PLACEMARKS_ICON_VALUE'],
         );
         
         if($key == "0" && $arParams['MAP_PLACE_CORDINATES'] == "N" && !empty($arParams['MAP_YANDEX_LAN']) && !empty($arParams['MAP_YANDEX_LON'])) {
            $arResult['POSITION']['yandex_lat'] = $arParams['MAP_YANDEX_LAN'];
            $arResult['POSITION']['yandex_lon'] = $arParams['MAP_YANDEX_LON'];      
         } elseif($key == "0") {
            $arResult['POSITION']['yandex_lat'] = $arItemPoint[0];
            $arResult['POSITION']['yandex_lon'] = $arItemPoint[1];      
         }
}                              
?>