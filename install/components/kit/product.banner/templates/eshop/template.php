<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $arViewFilter;
$arViewFilter = $arResult;
if(!empty($arResult))
{
	echo "<h3>".GetMessage("SBT_PRODUCTVIEW_TITLE")."</h3>";
	$APPLICATION->IncludeComponent("bitrix:eshop.catalog.top", "", array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
	    "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
	    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
	    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	    "FILTER_NAME" => "arViewFilter",
	    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
	    "ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
	    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
	    "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
	    "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
	    "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
	    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
	    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
	    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
	    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
	    "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
	    "SECTION_URL" => $arParams["SECTION_URL"],
	    "DETAIL_URL" => $arParams["DETAIL_URL"],
	    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
	    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
	    "CACHE_TIME" => $arParams["CACHE_TIME"],
	    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	    "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
	    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
	    "PRICE_CODE" => $arParams["PRICE_CODE"],
	    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
	    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
	    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
	    "BASKET_URL" => $arParams["BASKET_URL"],
	    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
	    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
	    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
	    "ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
	    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
	    "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
	    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
	    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
	    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"]
		),
		$component
	);

}
