<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(isset($arResult["FANCY"]) && !empty($arResult["FANCY"]))
{
    foreach($arResult["FANCY"] as $arItem)
    {
        $quick_view_id[] = $arItem['ID'];
        $detail_page[] = $arItem["DETAIL_PAGE_URL"];
    }
    
    $APPLICATION->IncludeComponent(
    "kit:kit.quick.view_new",
    "",
    Array(
        "ELEMENT_ID" => $quick_view_id,
        "PARAB2BS_CATALOG" => $arParams,
        "ELEMENT_TEMPLATE" => 'preview',
        "DETAIL_PAGE_URL" => $detail_page,
        "RAND" => $arResult["RAND"]
    ),
    false
    );    
}
?>