<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(isset($arResult["FANCY"]) && !empty($arResult["FANCY"]) && $arResult["IS_FANCY"])
{
    foreach($arResult["FANCY"] as $arItem)
    {
        $quick_view_id[] = $arItem['ID'];
        $detail_page[] = $arItem["DETAIL_PAGE_URL"];
    }
    
    $APPLICATION->IncludeComponent(
    "sotbit:sotbit.quick.view_new",
    "",
    Array(
        "ELEMENT_ID" => $quick_view_id,
        "PARAB2BS_CATALOG" => $arParams["DETAIL_PARAMS"],
        "ELEMENT_TEMPLATE" => 'preview',
        "DETAIL_PAGE_URL" => $detail_page,
        "RAND" => $arResult["RAND"]
    ),
    false
    );    
}

global $sMSRightBlockCount, $msAnalogDeleteID;
if(isset($arResult["COUNT"]) && $arResult["COUNT"]>0)
{   
    $sMSRightBlockCount++;
    foreach($arResult["FANCY"] as $arItem)
    {
        $msAnalogDeleteID[] = $arItem["ID"];   
    }    
}
?>